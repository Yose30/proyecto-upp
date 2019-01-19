<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Course;
use App\Category;
use App\Level;
use App\Lesson;
use App\Review;
use App\Student;
use App\User;
use App\Advance;
use App\Teacher;
use App\Result;
use App\Question;
use App\Role;
use DevDojo\Chatter\Models\Models;
use App\Notifications\CourseConcluded;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    /*******ESTUDIANTES*******/
    //Funcion para mostrar los cursos que a cursado el alumno y para mostrar los cursos con estado PUBLICADO y ordenados ascendentemente de acuerdo a su prioridad
    public function registered_courses(){
        //Obtener todos los cursos con estado PUBLICADO
        $all_courses = Course::orderBy('prioridad', 'ASC')
           ->where([['estado', Course::PUBLICADO]])
           ->get();
        //Obtener el curso que el alumno este cursando
        $course_inscribe = \DB::table('course_student')->where([
            ['student_id', auth()->user()->student->id], 
            ['situacion', Course::CURSANDO]
        ])->first(); 
        return view('courses.registered_courses', compact('course_inscribe', 'all_courses'));
    }

    //Funcion para mostrar los detalles del curso
    public function course_details($slug){
        //Obtiene el curso mediante el slug
        $course = Course::whereSlug($slug)
                ->with('lessons', 'teacher', 'advances')
                ->first();
        //Obtiene el curso al que esta inscrito el alumno
        $course_advance = \DB::table('course_student')->where([
            ['student_id', auth()->user()->student->id], 
            ['course_id', $course->id]
        ])->first(); 
        //Obtiene el numero de cursos que el alumno esta cursando, debe ser 0 o 1
        $num_cursando = \DB::table('course_student')->where([['course_id', $course->id], ['situacion', Course::CURSANDO]])->count();
        //Obtiene todos los usuarios con rol de estudiante
        $users = User::where('role_id', \App\Role::ESTUDIANTE)->get();
        return view('courses.course_details', compact('course', 'course_advance', 'users', 'num_cursando'));
    }

    //Para obtener la vista en donde se realizara la valoración del curso
    public function valoracion($id){
        //Obtiene el curso mediante el id
        $course = Course::whereId($id)->first();
        //Obtiene todos los usuarios con rol de estudiante
        $users = User::where('role_id', \App\Role::ESTUDIANTE)->get();
        return view('courses.valoracion', compact('course', 'users'));
    }

    //Función para que el alumnos agrege una valoracion y/o comentario
    public function add_review(){
        try{
            \DB::beginTransaction();
            Review::create([
                'user_id' => auth()->id(),
                'course_id' => request('course_id'),
                'rating' => (int) request('rating_input'),
                'comentario' => request('message')
            ]);
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return back()->with('message', ['success', __("Muchas gracias por valorar el curso")]);
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    }

    //Función para obtener si el curso a finalizado
    public function course_finished($id){
        //Se obtiene el curso mediante el id, junto con sus leccione
        $course = Course::whereId($id)->with('lessons')->first();
        //Obtine todas las respuestas correctas del curso y del estudiante
        $correctas = Result::where([['course_id', $id], ['student_id', auth()->user()->student->id], ['answer', Result::CORRECTO]])->get();
        //Obtiene todos los resultados del estudiante de ese curso
        $results = Result::where([['course_id', $id], ['student_id', auth()->user()->student->id]])->get();
        //Obtiene el estado que tiene el estudiante en base al curso, ya sea cursando o cursada
        $estado_course = \DB::table('course_student')->where([['course_id', $course->id], ['student_id', auth()->user()->student->id]])->first();
        return view('courses.finished', compact('course', 'correctas', 'results', 'estado_course'));
    }

    //Función para obtener la pregunta de la lección
    public function question($id, $opportunity){
        //Se obtiene la lección mediante el id
        $lesson = Lesson::whereId($id)->first();
        //Se obtiene el numero de lecciones del curso
        $lessons = Lesson::where('course_id', $lesson->course_id)->count();
        //Obtiene la siguiente prioridad
        $next = $lesson->prioridad + 1;
        //Si la siguiente prioridad es mayor al numero de lecciones, asigna a la variable next_lesson un false
        if ($next > $lessons)
            $next_lesson = false;
        else{
            //De no ser asi, obtiene la siguiente lección, mediante el numero de prioridad y el id del curso
            $next_lesson = Lesson::where([
                ['prioridad', $next], 
                ['course_id', $lesson->course_id]
            ])->first();
        }
        //Hace una verificación del numero de oportunidad
        $verificar = Result::where([['lesson_id', $id], ['student_id', auth()->user()->student->id], ['opportunity', $opportunity]])->count();
        return view('courses.question', compact('lesson', 'verificar', 'opportunity', 'next_lesson'));
    }

    //Función para validar la pregunta, si es correcta o incorrecta
    public function validate_question(){
        try {
            \DB::beginTransaction();
            //Guarda el resultado del estudiante
            $result = new Result();
            $result->course_id  = request('course_id');
            $result->lesson_id  = request('lesson_id');
            $result->question_id = request('question_id');
            $result->student_id = auth()->user()->student->id;
            $result->answer     = request('answer');
            $result->opportunity = request('opportunity');
            $result->save();

            //Si la respuesta guardada es correcta devuelve el mensaje de correcto
            if($result->answer == Result::CORRECTO){
                $data = ['success' => true, 'message' => Result::CORRECTO];
            }
            else{
                $data = ['success' => true, 'message' => Result::INCORRECTO];
            }
            $estado = true;
            
        } catch (Exception $e) {
            \DB::rollBack();
            $data = ['success' => false, 'message' => 0];
            $estado = $exception->getMessage();
        }
        if ($estado === true) {
            \DB::commit();
        }
        return response()->json($data);
    }

    //Función para notificar al administrador, que se inscriba al siguiente curso
    public function send_notification(Course $course){
        //Se obtienen todos los usuarios con rol de administrador
        $users = User::where('role_id', Role::ADMINISTRADOR)->get();
        try {
            \DB::beginTransaction();
            //Se les notifica a todos los administradores que se a concluido el curso
            foreach ($users as $user) {
                $user->notify(new CourseConcluded(auth()->user(), $course));
            } 
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return back()->with('message', ['success', __('Correcto, te haremos llegar un correo')]);
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    }
    /*******FIN ESTUDIANTES*******/
    
    /*******ADMINISTRADOR*******/
    //Función que pasa los datos necesarios para crear un curso
    public function create(){
        //Se envia un objeto de la clase Course
        $course = new Course;
        return view('courses.create', compact('course'));
    }

    //Función para guardar el curso
    public function store(Request $request){
        //Validación de los campos para crear el curso
        $this->validate(request(), [
            'nombre' => 'min:5|max:60|required|string|unique:courses',
            'descripcion' => 'min:8|max:150|required|string',
            'objetivo' => 'min:8|max:150|required|string',
            'image' => 'image|mimes:jpg,png,jpeg',
            'tiempo' => 'required|numeric|min:1|max:9',
            'prioridad' => 'unique:courses|numeric|required|min:1|max:99'
        ]);
        try{
            \DB::beginTransaction();
            //Cargar imagen
            if($request->hasFile('imagen')){
                $imagen = Helper::uploadFile('imagen', 'courses');
                $request->merge(['imagen' => $imagen]);
            }
            //Crear nuevo curso
            $course = new Course();
            $course->administrator_id = auth()->user()->administrator->id;
            //$course->level_id = $request->input('level_id');
            $course->nombre = $request->input('nombre');
            $course->descripcion = $request->input('descripcion');
            $course->objetivo = $request->input('objetivo');
            $course->imagen = $request->input('imagen');
            $course->prioridad = $request->input('prioridad');
            $course->tiempo = $request->input('tiempo');
            $course->save();
            //Crear categoria para el foro
            $categorie = Models::category()->create([
                'parent_id'  => null,
                'order'      => 1,
                'name'       => $course->nombre,
                'slug'       => $course->slug,
            ]);
            $success = true;
        } catch (Exception $e) {
            DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return back()->with('message', ['success', __('Curso creado correctamente. En la sección de Cursos podrás visualizarlo')]);
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    }

    //Función para obtener la vista de edición del curso
    public function edit($id){
        //Se obtiene el curso con su id
        $course = Course::whereId($id)->first();
        //Se obtienen todos los usuarios con rol de profesor
        $users = User::where('role_id', Role::PROFESOR)->get();
        return view('courses.create', compact('course', 'users'));
    }

    //Función para actualizar el curso
    public function update(Course $course, Request $request){
        //Validación de los campos
        $this->validate(request(), [
            'nombre' => 'min:5|required|string',
            'descripcion' => 'min:8|required|string',
            'objetivo' => 'min:8|required|string',
            'image' => 'image|mimes:jpg,png,jpeg',
            'tiempo' => 'required|numeric',
            'prioridad' => 'numeric|required'
        ]);
        try{
            \DB::beginTransaction();
            //Guardar imagen en caso de que asi sea
            if($request->hasFile('imagen')){
                $imagen = Helper::uploadFile('imagen', 'courses');
                $request->merge(['imagen' => $imagen]);
                $course->imagen = $request->input('imagen');
            }
            //Si ya hay profesores en la lista se busca el que se alla seleccionado y se guarda
            if ($request->input('user_id') != 0) {
                $teacher = Teacher::where('user_id', $request->input('user_id'))->first();
                $course->teacher_id = $teacher->id;
            }
            else{
                //Si no es asi, se guarda en null
                $course->teacher_id = null;
            }
            //Se modifica el nombre de la categoria del foro, en caso de ser modificado el nombre del curso
            $category = Models::category()->where('slug', $course->slug)->update([
                'name' => $request->input('nombre'),
                'slug'=> str_slug($request->input('nombre'), "-")
            ]);

            //Se guardan los datos del curso
            $course->nombre = $request->input('nombre');
            $course->prioridad = $request->input('prioridad');
            $course->descripcion = $request->input('descripcion');
            $course->objetivo = $request->input('objetivo');
            $course->tiempo = $request->input('tiempo');
            $course->save();

            $success = true;
        }catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return back()->with('message', ['success', __('Curso actualizado correctamente')]);
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    }

    //Funció para borrar el curso
    public function delete($id){
        try {
            \DB::beginTransaction();
            //Buscar el curso
            $course = Course::find($id);
            //Busca la categoria del foro
            $category = Models::category()->where('slug', $course->slug)->first();
            //Borra la categoria del curso
            $category->delete();
            //Borrar el curso
            $course->delete();
            
            //Obtener todos los cursos
            $courses = Course::get();
            //Variables false y null
            $resultado1 = false;
            $resultado2 = false;
            $curso = NULL;

            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return redirect(route('admin.inicio', compact('courses', 'resultado1', 'resultado2', 'curso')))
                ->with('message', ['info', __("Curso eliminado correctamente")]);
        }
        //return view('admin.inicio', compact('courses', 'resultado1', 'resultado2', 'curso'));
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    }

    //Función para mostrar los detalles y su contenido de cada curso
    public function lessons($slug){
        //Se busca el curso con el slug y se retorna
        $course = Course::whereSlug($slug)->with('lessons')->first();
        $users = User::where('role_id', \App\Role::ESTUDIANTE)->get();
        return view('courses.lessons', compact('course', 'users'));
    }

    public function enrolled_students($id){
        $course = Course::whereId($id)->first();
        $course_advance = \DB::table('course_student')->where([['course_id', $course->id], ['situacion', Course::CURSANDO]])->get(); 
        $users = User::where('role_id', Role::ESTUDIANTE)->withTrashed()->paginate(10);
        return view('courses.enrolled_students', compact('course', 'course_advance', 'users'));
    }
    /*******FIN ADMINISTRADOR*******/
}

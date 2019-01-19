<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper;
use DevDojo\Chatter\Models\Models;
use App\Lesson;
use App\Course;
use App\Student;
use App\Question;
use App\Answer;
use App\Result;
use App\Advance;
use App\File;
use App\User;

class LessonController extends Controller
{
	/*******ESTUDIANTES*******/
	//Funcion para mostrar los detalles de la leccion
    public function lesson_detail($id){
        $lesson = Lesson::whereId($id)->with('course', 'files')->first();
        $advance = Advance::where([['course_id', $lesson->course->id], ['lesson_id', $id], ['student_id', auth()->user()->student->id], ['estado', Lesson::CONCLUIDO]])->count();
        $users = User::all();
        return view('lessons.lesson', compact('lesson', 'advance', 'users'));
    }

    //Lecciòn para mostrar la pregunta de cada lecciòn
    public function question($id){
        $q = Question::all()->where('lesson_id', $id)->random()->id;
        $question = Question::where('id', $q)->with('lesson', 'answers')->first();
        $lessons = Lesson::where('course_id', $question->lesson->course->id)->count();
        $results = Result::where([['course_id', $question->lesson->course->id], ['answer', Result::CORRECTO], ['student_id', auth()->user()->student->id], ['opportunity', 1]])->count();
        $puntuacion = $results." / ".$lessons;

        $verificar = Result::where([['lesson_id', $question->lesson_id], ['student_id', auth()->user()->student->id], ['opportunity', 1]])->count();

        //Ubicarse en la siguiente lección
        $lesson = Lesson::whereId($id)->first();
        $next = $lesson->prioridad + 1;
        if ($next > $lessons)
            $next_lesson = false;
        else{
            $next_lesson = Lesson::where([
                ['prioridad', $next], 
                ['course_id', $lesson->course_id]
            ])->with('course')->first();
        }
        return view('lessons.question', compact('question', 'next_lesson', 'puntuacion', 'verificar'));
    }

    //Función para validar la respuesta de la pregunta y para actualizar el estado de la leccion
    public function validate_question(){
        try{
            //Agregar resultado
            $result = new Result();
            $result->course_id  = \request('course_id');
            $result->lesson_id  = \request('lesson_id');
            $result->question_id = \request('question_id');
            $result->student_id = auth()->user()->student->id;
            $result->answer     = \request('answer');
            $result->save();

            //Obtener si el estudiante tiene la leccion actual como pendiente
            $count_advance = Advance::where([
                ['lesson_id', \request('lesson_id')],
                ['course_id', \request('course_id')],
                ['student_id', auth()->user()->student->id],
                ['estado', Lesson::PENDIENTE]
            ])->count();

            //Si es asi, actualiza el estado a concluido
            if($count_advance > 0){
                $search_advance = Advance::where([
                    ['lesson_id', \request('lesson_id')],
                    ['course_id', \request('course_id')],
                    ['student_id', auth()->user()->student->id]
                ])->update(['estado' => Lesson::CONCLUIDO]);
            } 
            else{
                // Si no, Agregar avance de las lecciones (lección completa)
                $advance = new Advance();
                $advance->course_id = \request('course_id');
                $advance->lesson_id = \request('lesson_id');
                $advance->student_id = auth()->user()->student->id;
                $advance->estado = Lesson::CONCLUIDO;
                $advance->save();
            }

            //Cuenta el nuemero de avances del estudiante con estado concluido y despues obtiene su porcentaje y lo guarda
            $completed = Advance::where([['student_id', auth()->user()->student->id],['course_id', \request('course_id')],['estado', Lesson::CONCLUIDO]])->count();
            $course = Course::whereId(\request('course_id'))->first();

            $student_advance = \DB::table('course_student')->where([
                ['student_id', auth()->user()->student->id], 
                ['course_id', $course->id]
            ])->update(['avance' => $completed * (100 / $course->lessons_count)]);

            if (\request('next_id') != 0) {
                //lección por completar
                $advance2 = new Advance();
                $advance2->course_id = \request('course_id');
                $advance2->lesson_id = \request('next_id');
                $advance2->student_id = auth()->user()->student->id;
                $advance2->estado = Lesson::PENDIENTE;
                $advance2->save();
            }

            if($result->answer == Result::CORRECTO){
                $data = ['success' => true, 'message' => Result::CORRECTO];
            }
            else{
                $data = ['success' => true, 'message' => Result::INCORRECTO];
            }
            $res = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $data = ['success' => false, 'message' => 0];
            $res = $exception->getMessage();
        }
        if ($res === true) {
            \DB::commit();
        } 
        return response()->json($data);  
    }

    /*******ADMINISTRADOR*******/

    //Función para obtener la vista para crear la lección
    public function create($slug){
        //Se envia el objeto lección
        $lesson = new Lesson;
        //Se busca el curso al que pertenecera, mediante el slug
        $course = Course::whereSlug($slug)->first();
        return view('lessons.create', compact('lesson', 'course'));
    }

    //Función para crear la lección
    public function store(Request $request){
        //Se crea una variable para comprobar que el video pertenece a youtube
        $youtube = 'www.youtube.com/';
        //Se obtiene el link que ingrese el administrador
        $link = $request->input('link_video');
        //Se comprueba si la cadena contiene la variable youtube
        if (strpos($link, $youtube) == false) {
            //Retorna un mensaje de error en caso de ser asi
            return back()->with('message', ['danger', __("Lo sentimos, el link del video es incorrecto, vuelve a intentarlo")]);
        }
        else{
            //Si el link, es correcto hace la validación de los demas campos
            $this->validate(request(), [
                'titulo' => 'min:5|max:60|required|string|unique:lessons',
                'descripcion' => 'min:8|max:150|required|string',
                'link_video' => 'min:35|max:200|required|string',
                'questions.0'   => 'required_with:questions.1|required_with:questions.2|required_with:questions.3|min:5',
                'questions.1'   => 'required_with:questions.0|min:5',
                'questions.2'   => 'required_with:questions.1|min:5',
                'questions.3'   => 'required_with:questions.2|min:5',
            ]);
            try {
                \DB::beginTransaction();
                //Busca el curso con el id enviado atraves de request
                $course = Course::whereId($request->input('course_id'))->first();
                //Corta la cadena del link del video, obteniendo solo la clave
                $clave_video = substr($link, 32);
                //Creación de la nueva lección
                $lesson = new Lesson();
                $lesson->course_id = $course->id;
                $lesson->titulo = $request->input('titulo');
                $lesson->prioridad = $course->lessons_count + 1;
                $lesson->descripcion = $request->input('descripcion');
                $lesson->link_video = $clave_video;
                $lesson->save();
                //Obtiene la categoria del foro con el slug del curso
                $category = Models::category()->where('slug', $course->slug)->first();
                //Crea el nuevo foro de discusión de la lección
                $discussion = Models::discussion()->create([
                    'chatter_category_id' => $category->id,
                    'title'               => $lesson->titulo,
                    'user_id'             => auth()->user()->id,
                    'sticky'              => 0,
                    'views'               => 0,
                    'answered'            => 0,
                    'slug'                => $lesson->slug
                ]);
                //Crear un post
                $new_post = [
                    'chatter_discussion_id' => $discussion->id,
                    'user_id'               => auth()->user()->id,
                    'body'                  => 'Bienvenidos!!',
                ];
                $discussion->users()->attach(auth()->user()->id);
                $post = Models::post()->create($new_post);
                $success = true;
            } catch (Exception $e) {
                \DB::rollBack();
                $success = $exception->getMessage();
            }
            if ($success === true) {
                \DB::commit();
                return back()->with('message', ['success', __("Lección creada correctamente, vuelva a la lista para visualizarla")]);
            }
            return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
        }
    }

    //Función para obtener la vista de editar la lección
    public function edit($id){
        //Obtiene la lección mediante el id
        $lesson = Lesson::whereId($id)->first();
        //Obtiene el curso mediante el id
        $course = Course::whereId($lesson->course_id)->first();
        return view('lessons.create', compact('lesson', 'course'));
    }

    //Función para actualizar la lección
    public function update(Lesson $lesson, Request $request){
        //Se crea una variable para comprobar que el video pertenece a youtube
        $youtube = 'www.youtube.com/';
        //Se obtiene el link que ingrese el administrador
        $link = $request->input('link_video');
        //Se comprueba si la cadena contiene la variable youtube
        if (strpos($link, $youtube) == false) {
            //Retorna un mensaje de error en caso de ser asi
            return back()->with('message', ['danger', __("Lo sentimos, el link del video es incorrecto, vuelve a intentarlo")]);
        }
        else{
            //Validación de los campos de la lección
            $this->validate(request(), [
                'titulo' => 'required|string|min:5',
                'descripcion' => 'min:8|required|string',
                'link_video' => 'min:5|string|required',

                'questions.0'   => 'required_with:questions.1|required_with:questions.2|required_with:questions.3|min:5',
                'questions.1'   => 'required_with:questions.0|min:5',
                'questions.2'   => 'required_with:questions.1|min:5',
                'questions.3'   => 'required_with:questions.2|min:5',
            ]);
            
            try {
                \DB::beginTransaction();
                //Si se actualiza el titulo de la lección, tambien se actualiza el titulo de la discusión del foro
                $discussion = Models::discussion()->where('slug', $lesson->slug)->update([
                    'title' => $request->input('titulo'),
                    'slug' => str_slug($request->input('titulo'), "-")
                ]);
                //Corta la cadena del link del video, obteniendo solo la clave
                $clave_video = substr($link, 32);
                //Se actualiza la lección, junto con las preguntas
                $lesson->fill($request->input())->save();
                //Se actualiza la clave, en caso de ser necesario
                $lesson->update(['link_video' => $clave_video]);
                $success = true;
            } catch (Exception $e) {
                \DB::rollBack();
                $success = $exception->getMessage();
            }
            if ($success === true) {
                \DB::commit();
                return back()->with('message', ['success', __('Lección actualizada correctamente')]);
            }
            return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]); 
        }
    }

    //Función para mostrar los detalles de la lección para el administrador
    public function details_for_admin($id){
        //Se busca la lección en base al id
        $lesson = Lesson::whereId($id)->first();
        //Se obtienen todos los usuarios
        $users = User::all();
        return view('lessons.details', compact('lesson', 'users'));
    }

    //Función para editar las respuestas
    public function edit_answers($id){
        //Busca a la pregunta a la que perteneceran las respuestas, mediante el id
        $question = Question::whereId($id)->first();
        $questions = Question::all()->where('lesson_id', $question->lesson_id);
        //Obtiene la respuesta correcta
        $correcta = $question->answers->where('type', 1)->first();
        return view('lessons.answers', compact('question', 'correcta', 'questions'));
    }

    //Función para agregar las respuestas
    public function answers_store(Request $request){
        //Validación de los campos
        $this->validate(request(), [
            'answers.0'   => 'required_with:answers.1|required_with:answers.2|min:5',
            'answers.1'   => 'required_with:answers.0|min:5',
            'answers.2'   => 'required_with:answers.1|min:5'
        ]);
        try{
            \DB::beginTransaction();
            //Declarar tres variables de tipo incorrecto
            $type1 = \App\Result::INCORRECTO;
            $type2 = \App\Result::INCORRECTO;
            $type3 = \App\Result::INCORRECTO;
            //La respuestas que haya sido como correcta, se modificar en la variable
            if ($request->input('type') == 0)
                $type1 = \App\Result::CORRECTO;
            if ($request->input('type') == 1)
                $type2 = \App\Result::CORRECTO;
            if ($request->input('type') == 2)
                $type3 = \App\Result::CORRECTO;
            //Se guardar las 3 respuestas de las preguntas
            $answer1 = Answer::create([
                'question_id' => $request->input('question_id'),
                'answer' => $request->answers[0],
                'type' => $type1
            ]);
            $answer2 = Answer::create([
                'question_id' => $request->input('question_id'),
                'answer' => $request->answers[1],
                'type' => $type2
            ]);
            $answer3 = Answer::create([
                'question_id' => $request->input('question_id'),
                'answer' => $request->answers[2],
                'type' => $type3
            ]);
            $success = true;
        }catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return back()->with('message', ['success', __('Respuestas agregadas correctamente')]);
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    }

    public function answers_update(Request $request, $id){
        $this->validate(request(), [
            'answers.0'   => 'required_with:answers.1|required_with:answers.2|min:5',
            'answers.1'   => 'required_with:answers.0|min:5',
            'answers.2'   => 'required_with:answers.1|min:5'
        ]);

        $answer1 = Answer::whereId($request->input('answer_id0'))->first();
        $answer2 = Answer::whereId($request->input('answer_id1'))->first();
        $answer3 = Answer::whereId($request->input('answer_id2'))->first();
        
        $type1 = \App\Result::INCORRECTO;
        $type2 = \App\Result::INCORRECTO;
        $type3 = \App\Result::INCORRECTO;
        if ($request->input('type') == 0)
            $type1 = \App\Result::CORRECTO;
        if ($request->input('type') == 1)
            $type2 = \App\Result::CORRECTO;
        if ($request->input('type') == 2)
            $type3 = \App\Result::CORRECTO;

        try {
            \DB::beginTransaction();
            $answer1->fill(['answer' => $request->answers[0], 'type' => $type1])->save();
            $answer2->fill(['answer' => $request->answers[1], 'type' => $type2])->save();
            $answer3->fill(['answer' => $request->answers[2], 'type' => $type3])->save();
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage(); 
        }
        if ($success === true) {
            \DB::commit();
            return back()->with('message', ['success', __('Actualización realizada correctamente')]); 
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);     
    }

    public function delete($id){
        $lesson = Lesson::find($id);
        try {
            \DB::beginTransaction();
            $lesson->delete();
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return back()->with('message', ['dark', __("Lecciòn eliminada correctamente")]);
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);     
    }

    /*******FIN ADMINISTRADOR*******/
}

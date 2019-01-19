<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PreRegister;
use App\User;
use App\Role;
use App\Student;
use App\Conversation;
use App\Teacher;
use App\Course;
use App\Lesson;
use App\Advance;
use App\Result;
use Carbon\Carbon;
use App\Mail\SendToNewUser;
use App\Mail\CoursePublished;
use App\Mail\CoursesFinished;
use Illuminate\Support\Facades\Hash;
use App\Mail\AccessToCourse;
use App\VueTables\EloquentVueTables;

class AdministratorController extends Controller
{
	//Función para obtener los alumnos pre-registrados
	public function pre_register(){
		//Obtener todos los pre-registros en orden Descendente, y de 10 en 10
		$registers = PreRegister::orderBy('id', 'DESC')->paginate(10);
		//Marcar como leidas las notificaciones de pre-registros, al momento de entrar a esta sección
        foreach (auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewPreRegister') as $notification) {
            $notification->markAsRead();
            $notification->delete();
        }

		return view('admin.pre_register', compact('registers'));
	}

	//Función para aprobar a un pre-registro
	public function approve_student(){
		try{
    		\DB::beginTransaction();
			//Obtener año
	        $anio = substr(Carbon::now()->format('Y'), 2, 2);
	        //Obtener mes
	        $mes = Carbon::now()->format('m');
	        //Obtener el periodo
	        if($mes == "01" || $mes == "02" || $mes == "03" || $mes == "04")
	            $periodo = 1;
	        if($mes == "05" || $mes == "06" || $mes == "07" || $mes == "08")
	            $periodo = 2;
	        else
	        	$periodo = 3; 
	        //Obtener el numero de estudiantes actual + 1
	        $u = Student::all()->count() + 1;
	        //Unir cadenas de acuerdo al numero de estudiantes
	        if($u < 9)
	        	$num = "000".$u;
	        else
	        	$num = "00".$u;
	        //Crear clave por fecha y numero de estudiante
	        $clave = $anio.$periodo.$num;
	        //Obtener datos del formulario
	        $info = \request('info');
			$data = [];
	    	parse_str($info, $data);
	    	//Obtener contraseña aleatoria
	        $contrasena = str_random(8);
  
    		//Agregar el registro del usuario
			$user = new User();
			$user->role_id = Role::ESTUDIANTE;
			$user->name = $data['nameu'];
			$user->lastName = $data['lastName'];
			$user->email = $data['email'];
			$user->clave = $clave;
			$user->password = Hash::make($contrasena);
			$user->view_password = $contrasena;
			$user->confirmed = 1;
			$user->save();
			//Agregar el registro del estudiante
			$student = new Student();
			$student->user_id = $user->id;
			$student->carrera = $data['carrera'];
			$student->domicilio = $data['domicilio'];
			$student->telefono = $data['telefono'];
			$student->save();
			//Borrar el pre-registro de la BD
			$pre_register = PreRegister::where([['name', $user->name], ['email', $user->email]])->first();
			$pre_register->delete();
			//Obtener el curso de prioridad 1
			$course = Course::where([['prioridad', 1], ['estado', Course::PUBLICADO]])->first();
			//Inscribir al estudiante
			$course->students()->attach($student->id);
			//Actualizar la situación y fecha actual 
            $course->students()->update(['fecha_inscripcion' => Carbon::now()]);
            //Crear conversación profesor - estudiante
            $conversation = Conversation::create([ 
				'teacher_id' => $course->teacher->id,
				'user_id' => $user->id
			]);
            //Enviar email al nuevo estudiante, con sus datos y el acceso al nuevo curso
			\Mail::to($user->email)->send(new SendToNewUser($user->name, $user->lastName, $user->clave, $user->view_password));
			\Mail::to($user->email)->send(new AccessToCourse($user->name, $user->lastName, $course->teacher->user->name, $course->teacher->user->lastName, $course->nombre, $course->slug));
			//Marcar como correcto el proceso
			$success = true;
		}
		catch(\Exception $exception){
			\DB::rollBack();
			//Marcar como incorrecto el proceso
    		$success = false;
    	}
    	if ($success === true) {
    		\DB::commit();
    	}
		return response()->json(['res' => $success]);
	}

	//Función para mostrar los cursos
	public function inicio(){
		//Obtener todos los cursos
		$courses = Course::get();
		//Obtener cursos publicados
		$publicados = Course::where('estado', Course::PUBLICADO)->get();
		//Inicializar variables
		$resultado1 = false;
		$resultado2 = false;
		//Obtener curso con prioridad 1
		$curso = Course::where('prioridad', 1)->first();
		//Si el numero de publicados es mayor a 0, realiza lo siuiente
		if($publicados->count() > 0){
			//Tiempo total de los cursos
			$tiempo = 0;
			//Guardar el tiempo total de los cursos y las prioridades de cada uno
			foreach ($publicados as $publicado) {
				$tiempo += $publicado->tiempo;
				//Obtener las prioridades
				$prioridades[] = $publicado->prioridad;
			}
			//Obtener el ultimo curso con la mayor prioridad
			$ultimo_curso = Course::where('prioridad', max($prioridades))->first();
			//Obtener los dias de diferencia entre la actualización del ultimo curso y la fecha actual
			$dias = $ultimo_curso->updated_at->diff(Carbon::now());
			//Obtener el numero de semanas
			$semanas = (int) $dias->format('%h') / 1;
			//Comparación entre el tiempo total y los dias
			$resultado1 = $semanas >= $tiempo;
		}
		else{
			//Si el numero de cursos publicados es cero, realiza lo siguiente
			if ($courses->count() > 0) {
				//Pero el numero de cursos es mayor a 0
				//Si el numero de estudiantes es mayor a 0 devuelve verdadero
				//Obtiene el curso con prioridad 1
				$uno = Course::where('prioridad', 1)->first();
				if ($uno != NULL && $uno->students_count > 0) {
					$resultado2 = true;
				}
			}
		}

		return view('admin.inicio', compact('courses', 'resultado1', 'resultado2', 'curso'));
	}

	//Función para iniciar o concluir el mantenimiento
	public function mantenimiento(){
		//Se cambian todos los cursos a pendiente
		Course::where('estado', Course::PUBLICADO)->update(['estado' => Course::PENDIENTE]);
		return back()->with('message', ['success', __("Listo, los cursos ya pueden ser editados")]);
		// //Si el estado esta como PUBLICADO
		// if ($estado == 2) {
			
		// }
		// else{
		// 	//Viceversa
		// 	Course::where('estado', Course::PENDIENTE)->update(['estado' => Course::PUBLICADO]);
		// 	return back()->with('message', ['success', __("Listo, los cursos ya se encuentran publicados de nuevo")]);
		// }
	}

	//Función para mostrar los cursos con vuetables
	public function coursesJson(){
    	if(request()->ajax()){
    		$vueTables = new EloquentVueTables;
	    	$data = $vueTables->get(new Course, ['id', 'nombre', 'estado', 'teacher_id'], ['teacher']);
    		return response()->json($data);
    	}
    	return abort(401);
    }

    //Función para actualizar el estado del curso
    public function updateCourseEstado($id){
    	//Obtiene todos los cursos
    	$courses = Course::get();
    	//Obtiene el curso que se quire modificar el estado
    	$course = Course::find($id);
    	//Si el estado se quiere publicar, se realiza lo siguiente
		if ($course->estado == Course::PENDIENTE) { 
			//Se guardan todas las prioridades en un arreglo
			foreach ($courses as $coursep) {
				$prioridades[] = $coursep->prioridad;
			}
			//Se verifica que el curso que se publicara sea el siguiente con respecto a los ya publicados
			if($course->prioridad == $courses->where('estado', Course::PUBLICADO)->count() + 1){
				//Inicialización de una variable para contar las respuestas
				$count_answers = 0;
				//Obtener el todal de las preguntas del curso
				$total = ($course->lessons_count * 4);
				//Si la siguiente condición se cumple se realiza lo siguiente
				if ($course->teacher_id != NULL && $course->imagen != NULL && $course->lessons_count > 0) {
					//Se verifica que cada pregunta tenga sus respuestas definidas, y se van acmulando en la variable count_answers
					foreach ($course->lessons as $lesson) {
						foreach ($lesson->questions as $question) {
							if ($question->answers_count > 0) {
								++$count_answers;
							}
						}
					}
					//Si no coinciden ambas variables no se podra publicar
					if ($count_answers != $total) {
						return back()->with('message', ['warning', __("Faltan respuestas de preguntas por definir")]);
					}
					else{
						//Si si cumple, se actualiza el estado a publicado
						$course->estado = Course::PUBLICADO;
			            $course->save();
						//Enviar email al profesor
			            \Mail::to($course->teacher->user->email)->send(new CoursePublished($course->teacher->user->name, $course->teacher->user->lastName, $course->nombre));
			            return back()->with('message', ['success', __("Curso dado de alta")]);
					}
				}
				else{
					return back()->with('message', ['warning', __("Faltan datos del curso, favor de revisar")]);
				}
			}
			else{
				return back()->with('message', ['warning', __("El curso no puede ser publicado, verifique la prioridad")]);
			}
		}
		else{
			$course->estado = Course::PENDIENTE;
	        $course->save();
			return back()->with('message', ['info', __("Curso dado de de baja")]);
		}
    }
   //  public function updateCourseEstado(){
   //      if (\request()->ajax()) {
   //      	//Obtiene todos los cursos
   //      	$courses = Course::get();
   //      	//Obtiene el curso que se quire modificar el estado
   //      	$course = Course::find(\request('courseId'));
   //      	//Si el estado se quiere publicar, se realiza lo siguiente
			// if (\request('estado') == 1) { 
			// 	//Se guardan todas las prioridades en un arreglo
			// 	foreach ($courses as $coursep) {
			// 		$prioridades[] = $coursep->prioridad;
			// 	}
			// 	//Se verifica que la prioridad mas alta coincida con el numero de cursos creados, si es asi realiza lo siguiente
			// 	if($courses->count() == max($prioridades)){
			// 		//Inicialización de una variable para contar las respuestas
			// 		$count_answers = 0;
			// 		//Obtener el todal de las preguntas del curso
			// 		$total = ($course->lessons_count * 4);
			// 		//Si la siguiente condición se cumple se realiza lo siguiente
			// 		if ($course->prioridad != NULL && $course->teacher_id != NULL && $course->imagen != NULL && $course->lessons_count > 0) {
			// 			//Se verifica que cada pregunta tenga sus respuestas definidas, y se van acmulando en la variable count_answers
			// 			foreach ($course->lessons as $lesson) {
			// 				foreach ($lesson->questions as $question) {
			// 					if ($question->answers_count > 0) {
			// 						++$count_answers;
			// 					}
			// 				}
			// 			}
			// 			//Si no coinciden ambas variables no se podra publicar
			// 			if ($count_answers != $total) {
			// 				return response()->json(['msg' => 'Faltan respuestas por definir']);
			// 			}
			// 			else{
			// 				//Si si cumple, se actualiza el estado a publicado
			// 				$course->estado = \request('estado');
			// 	            $course->save();
			// 				//Enviar email al profesor
			// 	            \Mail::to($course->teacher->user->email)->send(new CoursePublished($course->teacher->user->name, $course->teacher->user->lastName, $course->nombre));
			// 	            return response()->json(['msg' => 'Curso dado de alta']);
			// 			}
			// 		}
			// 		else{
			// 			return response()->json(['msg' => 'Faltan datos del curso, favor de revisar']);
			// 		}
			// 	}
			// 	else{
			// 		return response()->json(['msg' => 'Las prioridades no coinciden con el numero de cursos']);
			// 	}
			// }
			// else{
			// 	//Si el curso ya tiene alumnos inscritos, no se podra dar de baja
			// 	if ($course->students_count > 0) {
			// 		return response()->json(['msg' => 'El curso no de puede dar de baja']);
			// 	}
			// 	else{
			// 		$course->estado = \request('estado');
			//         $course->save();
			// 		return response()->json(['msg' => 'Curso dado de de baja']);
			// 	}
			// }
   //      }
   //      return abort(401);
   //  }

    //Función para borrar pre-registro
	public function delete_student($id){
		try {
			\DB::beginTransaction();
			//Se busca el pre-registro y se borra
			$pre_register = PreRegister::find($id);
			$pre_register->delete();
			$success = true;
		} catch (Exception $e) {
			\DB::rollBack();
    		$success = $exception->getMessage();
		}
		if($success === true){
			\DB::commit();
			return back()->with('message', ['dark', __("Registro eliminado")]);
		}
		return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
	}

	//Función para obtener la vista de usuarios 
	public function get_users(){
		return view('admin.users');
	}

	//Función para obtener a todos los estudiantes activos
	public function students(){
		//Obtiene a los estudiantes, incluso los que han sido dados de baja
		$students = User::where('role_id', Role::ESTUDIANTE)->with('student')->get();
		$information = 'partials.students.btn-information';
    	return \DataTables::of($students)
    		->addColumn('information', $information)
    		->rawColumns(['information'])->make(true);
	}

	//Función para obtener a todos los estudiantes inactivos
	public function students_inactive(){
		//Obtiene a los estudiantes, incluso los que han sido dados de baja
		$students_inactive = User::where('role_id', Role::ESTUDIANTE)->with('student')->onlyTrashed()->get();
		$information = 'partials.students.btn-information_inactive';
    	return \DataTables::of($students_inactive)
    		->addColumn('information', $information)
    		->rawColumns(['information'])->make(true);
	}

	//Función para obtener a todos los profesores
	public function teachers(){
		//Obtiene a todos los profesores, incluso los que han sido dados de baja
		$teachers = User::where('role_id', Role::PROFESOR)->with('teacher')->withTrashed()->get();
		$information = 'partials.teachers.btn-information';
    	return \DataTables::of($teachers)
    		->addColumn('information', $information)
    		->rawColumns(['information'])->make(true);
	}

	//Función para obtener todos los cursos creados
	public function courses(){
		//Obtiene todos los cursos
		$courses = Course::get();
		$information = 'partials.courses.btn-information';
    	return \DataTables::of($courses)
    		->addColumn('information', $information)
    		->rawColumns(['information'])->make(true);
	} 

	//Función para cambiar estado del curso al estudiante
	public function change_status($course_id, $student_id){
		//Busca el curso y al usuario (estudiante)
		$course = Course::find($course_id);
		$student = Student::find($student_id);
		try {
			\DB::beginTransaction();
			//Actualiza estado del curso actual cursando a cursada
			$course->students()->where([['course_id', $course->id], ['student_id', $student->id] ])->update(['situacion' => Course::CURSADA]);
			//Busca el siguiente curso
			$next = $course->prioridad + 1;
			//Comprueba que haya un siguiente curso
			if($next <= Course::where('estado', 1)->count()){
				$coursen = Course::where('prioridad', $next)->first();
				//Inscribe al alumnos al siguiente curso
		        $coursen->students()->attach($student->id); 
				//Actualizar la situación y fecha actual 
	            $coursen->students()->update(['fecha_inscripcion' => Carbon::now()]);

		        //Crear conversación con el profesor y el estudiante
		        $conversation = Conversation::create([ 
					'teacher_id' => $coursen->teacher->id,
					'user_id' => $student->user->id
				]);
		        //Enviar email, para notificar que puede acceder al siguiente curso
		        \Mail::to($student->user->email)->send(new AccessToCourse($student->user->name, $student->user->lastName, $coursen->teacher->user->name, $coursen->teacher->user->lastName, $coursen->nombre, $coursen->slug));
		        \DB::commit();
		        return back()->with('message', ['success', __("Inscrito correctamente")]);
		    } 
		    //Enviar email, para notificar que ha concluido el curso
	        \Mail::to($student->user->email)->send(new CoursesFinished($student->user->name, $student->user->lastName));
	        \DB::commit();
	        return back()->with('message', ['success', __("Correcto")]);
		} catch (Exception $e) {
			\DB::rollBack();
			return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
		}
	}

	//Función para reiniciar avance del alumno
	public function restart_progress($course_id, $student_id){
		//Buscar y borrar los avances y resultados del estudiante, en el curso correspondiente
		$advances = Advance::where([['course_id', $course_id], ['student_id', $student_id]])->get();
		$results = Result::where([['course_id', $course_id], ['student_id', $student_id]])->get();
		try {
			\DB::beginTransaction();
			//Guardar id's
			foreach($advances as $advance){
				$advance_id[]=$advance->id;
			}
			foreach($results as $result){
				$result_id[]=$result->id;
			}
			Advance::destroy($advance_id);
			Result::destroy($result_id);
			//Actualizar el estado del curso del estudiante
			$course_student = \DB::table('course_student')->where([['course_id', $course_id], ['student_id', $student_id]])->update(['avance' => 0]);
			$success = true;
		} catch (Exception $e) {
			\DB::rollBack();
			$success = $exception->getMessage();
		}

		if ($success === true) {
			\DB::commit();
			return back()->with('message', ['info', __("Datos del curso reiniciados")]);
		}
		return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
	}

	public function remove_status($id){
		try {
			\DB::beginTransaction();
			$actual = \DB::table('course_student')->where([
	            ['student_id', $id], 
	            ['situacion', Course::CURSANDO]
	        ])->delete();
	        $success = true;
		} catch (Exception $e) {
			\DB::rollBack();
			$success = $exception->getMessage();
		}
		if ($success === true) {
			\DB::commit();
			return back()->with('message', ['info', __("Acción realizada correctamente")]);
		}
		return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);

	}
}

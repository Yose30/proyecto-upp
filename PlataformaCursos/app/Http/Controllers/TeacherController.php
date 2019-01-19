<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Lesson;
use App\Student;
use App\User;
USE App\Teacher;
use App\Role;
use App\Conversation;
use App\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendToNewUser;
use App\Mail\RequestLowStudent;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    //Función para obtener los cursos asignados del profesor
    public function my_courses(){
      //Obtiene todos los cursos que se le hayan asignado al profesor y que esten publicados
    	$courses = Course::orderBy('prioridad', 'ASC')
        ->where([
        	['estado', Course::PUBLICADO], 
          ['teacher_id', auth()->user()->teacher->id]])
        ->get();
      //Variable declarada como false
      $resultado = false;
      //Si el numero de cursos es igual a 0
      if ($courses->count() == 0) {
        //Obtiene todos los cursos asignados del profesor pero que esten en estado pendiente
        $all_courses = Course::where([['teacher_id', auth()->user()->teacher->id], ['estado', Course::PENDIENTE]])
        ->get();
        //Si el numero de cursos es diferente de 0, guarda el numero de estudiantes de cada curso en un arreglo, y si la condicion es verdadero, lo guarda en la variable resultado
        if ($all_courses->count() != 0) {
          foreach ($all_courses as $course) {
            $arreglo[] = $course->students_count;
          }
          $resultado = max($arreglo) > 0;
        }
      }
      return view('teacher.courses.assigned', compact('courses', 'resultado'));
    } 

    public function details($slug){
    	$course = Course::whereSlug($slug)
            ->with('lessons', 'teacher')
            ->first();
      $num_cursando = \DB::table('course_student')->where([['course_id', $course->id], ['situacion', Course::CURSANDO]])->count();
      $users = User::where('role_id', \App\Role::ESTUDIANTE)->get();
      return view('teacher.courses.details', compact('course', 'users', 'num_cursando'));
    }

    public function enrolled_students($id){
      $course = Course::whereId($id)->first();
      $users = User::where('role_id', \App\Role::ESTUDIANTE)->withTrashed()->paginate(10);
      $courses = \DB::table('course_student')->where([['course_id', $course->id], ['situacion', Course::CURSANDO]])->get();
      return view('teacher.courses.enrolled_students', compact('course', 'courses', 'users'));
    }

    public function lesson($id){
      $lesson = Lesson::whereId($id)->first();
      $users = User::all();
      return view('teacher.courses.lesson', compact('lesson', 'users'));
    }

    //Función para crear un nuevo profesor
    public function store(){
      //Validación de los campos
      $validator = Validator::make(\request()->all(), [
        'nameu' => 'max:50|required|string',
        'lastname' => 'min:8|max:50|required|string',
        'email' => 'required|email|unique:users',
        'profesion' => 'min:5|max:50|required|string',
      ]);
      //Si falla retorna un mensaje de error
      if ($validator->fails()) {
        $success = false;
        return response()->json(['res' => $success]);
      }

      try{
        \DB::beginTransaction();
        //Obtiene el año actual
        $anio = substr(Carbon::now()->format('Y'), 2, 2);
        //Obtiene el numero de profesor + 1
        $u = Teacher::all()->count() + 1;
        //Une las cadenas de acuerdo al numero de caracteres
        if($u < 9)
          $num = "00".$u;
        else
          $num = "0".$u;
        //Crear clave por fecha y numero de PROFESOR
        $clave = 'F'.$anio.$num;
        //Obtiene la contraseña aleatoriamente
        $contrasena = str_random(8);
        //Crea el nuevo usuario
        $user = new User();
        $user->role_id = Role::PROFESOR;
        $user->name = \request('nameu');
        $user->lastName = \request('lastname');
        $user->email = \request('email');
        $user->clave = $clave;
        $user->password = Hash::make($contrasena);
        $user->view_password = $contrasena;
        $user->confirmed = 1;
        $user->save();
        //Crea a ese usuario como profesor
        $teacher = new Teacher();
        $teacher->user_id = $user->id;
        $teacher->profesion = \request('profesion');
        $teacher->save();
        //Crea la conversación entre el profesor y los administradores
        Conversation::create([ 
          'teacher_id' => $teacher->id,
          'user_id' => 1
        ]);
        Conversation::create([ 
          'teacher_id' => $teacher->id,
          'user_id' => 2
        ]);
        //Le envia un email, notificandole que se agrego a la plataforma junto con sus datos para acceder
        \Mail::to($user->email)->send(new SendToNewUser($user->name, $user->lastName, $user->clave, $user->view_password));
        //Retorna un mensaje de correcto
        $success = true;
        
      }catch (Exception $e) {
        \DB::rollBack();
        $success = false;
      }
      if ($success === true) {
        \DB::commit();
      }
      return response()->json(['res' => $success]);
    }

    public function send_email_low(){
      $info = \request('info'); 
      $data = [];
      parse_str($info, $data);
      $user = User::findOrFail($data['user_id']);
      $admins = User::where('role_id', Role::ADMINISTRADOR)->get();
      try{
        foreach ($admins as $admin) {
          \Mail::to($admin->email)->send(new RequestLowStudent($data['message'], $user->name, $user->slug, auth()->user()->name));
        }
        $success = true;
      }
      catch(\Exception $exception){
        $success = false;
      }

      return response()->json(['res' => $success]);
    }
}

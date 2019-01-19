<?php

namespace App\Http\Controllers;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Dropbox\Client;
use Illuminate\Support\Facades\Validator;
use App\Rules\StrengthPassword;
use App\Helpers\Helper;
use App\Student;
use App\User;
use App\Goal;
use App\Course;
use App\Role;
use App\Teacher;
use App\Mail\ConfirmEmail;
use App\Mail\DeleteUser;

class ProfileController extends Controller
{
    public function __construct(){
        $this->dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();   
    }

    public function profile($id, $slug){
        //Profesor o estudiante
        $user = User::whereSlug($slug)->first();
        //Si el usuario que quiere visitar es ESTUDIANTE
        if (auth()->user()->role_id == Role::PROFESOR){
            //Obtener datos del curso
            $course = Course::whereId($id)->first();
            //Obtiene su avance
            $avance_course = \DB::table('course_student')->where([['course_id', $id], ['student_id', $user->student->id]])->first();
            return view('profile.profile', compact('user', 'course', 'avance_course'));
        }

        if (auth()->user()->role_id == Role::ESTUDIANTE){
            //Obtener datos del curso
            $course = Course::whereId($id)->first();
            return view('profile.profile', compact('user', 'course'));
        }
        //Solo del Administrador tiene acceso a esta parte
        if (auth()->user()->role_id == Role::ADMINISTRADOR) {
            //Obtiene todos los cursos publicados
            $all_courses = Course::orderBy('prioridad', 'ASC')
               ->where([['estado', Course::PUBLICADO]])
               ->get();
             //Si visita el perfil del estudiante
            if ($user->role_id == Role::ESTUDIANTE){
                //Obtiene todos los cursos con estado CURSADA y CURSANDO
                $courses = \DB::table('course_student')->where('student_id', $user->student->id)->get();
                //Si hay notificaciones sin leer las marca como leidas
                foreach (auth()->user()->unreadNotifications->where('type', 'App\Notifications\CourseConcluded') as $notification) {
                    if ($notification->data['user']['id'] == $user->id) {
                        $notification->markAsRead();
                        $notification->delete();
                    }
                }
            }
            //O si visita el perfil del profesor
            if ($user->role_id == Role::PROFESOR){
                //Obtiene todos sus cursos asignados
                $courses = Course::where('teacher_id', $user->teacher->id)->get();
            }
            return view('profile.profile', compact('user', 'all_courses', 'courses'));
        }
    }

    public function edit($slug){
    	$user = User::whereSlug($slug)->first();
        if (auth()->user()->role_id == Role::ESTUDIANTE) {
            return view('profile.form_student', compact('user'));
        }
        if (auth()->user()->role_id == Role::PROFESOR) {
            return view('profile.form_teacher', compact('user'));
        }
        if (auth()->user()->role_id == Role::ADMINISTRADOR) {
            return view('profile.form_admin', compact('user'));
        }
    }

    public function store(Request $request, User $user){
        $this->validate($request, [
            'goals.0'   => 'required_with:goals.1|min:20',
            'goals.1'   => 'required_with:goals.0|min:20',
        ]);
        try {
            \DB::beginTransaction();
            $user->fill($request->input())->save();
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return back()->with('message', ['success', __('Objetivo(s) guardado(s)')]);
        }
        //Retorna un mensaje de fallo
        return back()->with('message', ['danger', __("Ha ocurrido un error, vuelve a intentarlo por favor")]);
    }

    public function update(Request $request, User $user){
        $this->validate($request, [
            'goals.0'   => 'required_with:goals.1|min:20',
        ]);
        try {
            \DB::beginTransaction();
            $user->fill($request->input())->save();
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return back()->with('message', ['success', __('Objetivo(s) actualizados')]);
        }
        //Retorna un mensaje de fallo
        return back()->with('message', ['danger', __("Ha ocurrido un error, vuelve a intentarlo por favor")]);
    }

    public function update_password(){
    	$this->validate(request(), [
    		'password' => ['confirmed', new StrengthPassword]
    	]);

    	try {
            \DB::beginTransaction();
            $user = auth()->user();
            $user->password = bcrypt(request('password'));
            $user->view_password = request('password');
            $user->save();
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if($success === true){
            \DB::commit();
            return back()->with('message', ['success', __('Contraseña actualizada correctamente')]); 
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    }

    //Función para actualizar la foto de perfil
    public function update_image(Request $request, User $user){
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpg,png,jpeg',
        ]);

        if ($validator->fails()) {
            return back()->with('message', ['danger', __('Formato de imagen no permitida, vuelve a intentarlo')]);
        }else{
            if($request->hasFile('image')){
                try {
                    \DB::beginTransaction();
                    if ($user->image != 'deei-image.jpg') {
                        \Storage::delete('users/'.$user->image);  
                    }
                    $image = Helper::uploadFile('image', 'users');
                    $request->merge(['image' => $image]);

                    $user = auth()->user();
                    $user->image = $request->input('image');
                    $user->save();
                    $success = true;
                } catch (Exception $e) {
                    \DB::rollBack();
                    $success = $exception->getMessage();
                }
                if($success === true){
                    \DB::commit();
                    return back()->with('message', ['success', __('Foto de perfil actualizada')]);
                }
                return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
            }
        }
        
        return back()->with('message', ['danger', __('Seleccionar foto de perfil')]);
    }

    public function update_email(User $user, Request $request){
        $this->validate(request(), [
            'email' => 'required|email|unique:users',
        ]);
        $user = auth()->user();
        if($user->email == request('email')){
            return back()->with('message', ['warning', __("Este correo electrónico ya está registrado")]);
        }
        try {
            \DB::beginTransaction();
            $user->email = request('email');
            $user->confirmed = false;
            $user->confirmation_code = str_random(25);
            $user->save();

            \Mail::to($user->email)->send(new ConfirmEmail($user->name, $user->confirmation_code));
            //Para enviar el email 
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if($success === true){
            \DB::commit();
            return back()->with('message', ['warning', __("Revisa tu correo electrónico para confirmar")]);
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    }

    public function update_biography(Request $request){
        $this->validate($request, [
            'biografia'   => 'required|min:20|max:300',
        ]);

        try {
            \DB::beginTransaction();
            $teacher = Teacher::whereId(auth()->user()->teacher->id)->first();
            $teacher->biografia = request('biografia');
            $teacher->save();
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if($success === true){
            \DB::commit();
            return back()->with('message', ['success', __('Biografía actualizada correctamente')]);
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    }

    public function update_curriculum(Request $request){
        $validator = Validator::make($request->all(), [
            'curriculum' => 'mimes:pdf|max:3000|unique:teachers'
        ]);
        if ($validator->fails()) {
            return back()->with('message', ['danger', __('El archivo no es de tipo .pdf o excedió los 3MB, intenta de nuevo')]);
        }
        else{
            try {
                \DB::beginTransaction();
                $teacher = Teacher::whereId(auth()->user()->teacher->id)->first();

                if ($teacher->curriculum != null) {
                    $this->dropbox->delete('/Aplicaciones/curriculums/'.$teacher->curriculum);
                } 
                Storage::disk('dropbox')->putFileAs(
                    '/Aplicaciones/curriculums/', 
                    $request->file('curriculum'), 
                    $request->file('curriculum')->getClientOriginalName()
                );
                $response = $this->dropbox->createSharedLinkWithSettings(
                    '/Aplicaciones/curriculums/'.$request->file('curriculum')->getClientOriginalName(), 
                    ["requested_visibility" => "public"]
                );
                
                $teacher->curriculum = $request->file('curriculum')->getClientOriginalName();
                $teacher->public_url = $response['url'];
                $teacher->save();
                $success = true;
            } catch (Exception $e) {
                \DB::rollBack();
                $success = $exception->getMessage();
            }

            if($success === true){
                \DB::commit();
                return back()->with('message', ['success', __("Curriculum subido correctamente")]);
            }
            return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
        }
    }

    public function verify_email($code){
        $user = User::where('confirmation_code', $code)->first();
        $user->confirmed = true;
        $user->confirmation_code = null;
        $user->save();
        return redirect()->route('profile.edit', ['slug' => $user->slug])
            ->with('message', ['success', __("Gracias por confirmar tu correo electrónico")]);
    }

    public function destroy_user($id){
    	$user = User::find($id);
        try {
            \DB::beginTransaction();
            \Mail::to($user->email)->send(new DeleteUser($user->name, $user->lastName));
            $user->delete();
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return redirect(route('admin.users'))
                ->with('message', ['info', __("Baja de usuario, realizada correctamente")]);
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
        
    }

    public function restore_user($id){
        User::withTrashed()->where('id', $id)->restore();
        return back()->with('message', ['success', __("Usuario restaurado correctamente")]);
    }
}

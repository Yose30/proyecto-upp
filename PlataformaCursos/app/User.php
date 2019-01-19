<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Role;
use App\Student;
use App\Teacher;
use App\Review;
use App\Goal;
use App\File;
use App\Message;
use App\Conversation;
use App\Administrator;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes; //Para borrado logico de los usuarios

    /* The attributes that are mass assignable.*/
    protected $fillable = [
        'id','name', 'lastName', 'email', 'password', 'clave'
    ];

    /*The attributes that should be hidden for arrays.*/
    protected $hidden = [
        'password', 'remember_token',
    ]; 

    //para acceder a la imagen del usuario
    public function pathAttachment(){
        return url("/images/users/".$this->image);
    }

    //1 a 1 (Inverso)
    //Un usuario solo pertenecera a un rol
    public function role(){
        return $this->belongsTo(Role::class);
    }

    //1 a 1
    //Un usuario solo tendra un rol como estudiante
    public function student(){
        return $this->hasOne(Student::class);
    }

    //1 a 1
    //Un usuario solo tendra un rol como teacher
    public function teacher(){
        return $this->hasOne(Teacher::class);
    }

    //1 a 1
    //Un usuario solo tendra un rol como administrador
    public function administrator(){
        return $this->hasOne(Administrator::class);
    }

    //1 a muchos
    //Un usuario puede hacer muchas valoraciones
    public function reviews(){
        return $this->hasMany(Review::class);
    }

    //1 a muchos
    //Un usuario podra subir muchos archivos
    public function files(){
        return $this->hasMany(File::class);
    }

    //1 a muchos (Inversa)
    //Un usuario podra enviar muchos mensajes 
    public function message(){
        return $this->hasMany(Message::class);
    }

    //1 a muchos
    //Un usuario puede tener muchas conversaciones
    public function conversations(){
        return $this->hasMany(Conversation::class);
    }

    protected static function boot () {
        parent::boot();
        //Mediante el evento creating se creara el slug mientras se este creando el usuario, siempre y cuando no se este creando un usuario desde la consola
        static::creating(function (User $user) {
            if( ! \App::runningInConsole()) {
                //Crear slug con nombre y apellido de la persona
                $user->slug = str_slug($user->name . " " . $user->lastName, "-");
            }
        });

        static::saved(function(User $user){
            if(! \App::runningInConsole()){
                if(request('goals')){
                    foreach (request('goals') as $key => $meta_input) {
                        Goal::updateOrCreate(['id' => request('meta_id'.$key)], [
                            'student_id' => $user->student->id,
                            'meta' => $meta_input
                        ]);
                    }
                }
            }
        });
    }

    //Para obtener el slug, en la busqueda
    public function getRouteKeyName(){
        return 'slug';
    }

    //Definir que tipo de navegación tiene el usuario, cargar el archivo correspondiente de acuerdo al usuario autentificado
    public static function navigation(){
        return auth()->check() ? auth()->user()->role->nombre : 'guest';
        //Con la función check Verifica si el usuario esta o no autentficado
        //Si si esta autentificado accede y mediante un objeto de la clase user (en este caso user()) accede al metodo rol() y extrae el nombre dle rol, de no ser asi sera invitado
    }

}

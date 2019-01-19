<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        //Crear y eliminar directorios para almacenar las imagenes de cursos y usuarios y tambien los archivos y curriculums
        //Borra los directorios
        Storage::deleteDirectory('courses');
        Storage::deleteDirectory('users');
        //Crea de nuevo los directorios
        Storage::makeDirectory('courses');
        Storage::makeDirectory('users');
        //3 Roles, administrador, profesor y estudiante
        factory(\App\Role::class, 1)->create(['nombre' => 'admin']);
        factory(\App\Role::class, 1)->create(['nombre' => 'teacher']);
        factory(\App\Role::class, 1)->create(['nombre' => 'student']);

        \DB::table('users')->insert([
            // 0 => [
            //     'id'                => 1,
            //     'role_id'           => \App\Role::ESTUDIANTE,
            //     'name'              => 'Camila',
            //     'lastName'          => 'Mondragon',
            //     'email'             => 'camila@gmail.com',
            //     'clave'             => '1830001',
            //     'password'          => bcrypt('secret'),
            //     'view_password'     => 'secret',
            //     'slug'              => 'camila-mondragon',
            //     'created_at'        => '2018-08-10 14:27:56',
            //     'updated_at'        => '2018-08-10 14:27:56',
            //     'remember_token'    => str_random(10),
            // ],
            // 1 => [
            //     'id'                => 2,
            //     'role_id'           => \App\Role::ESTUDIANTE,
            //     'name'              => 'Mario',
            //     'lastName'          => 'Santillan',
            //     'email'             => 'mario@gmail.com',
            //     'clave'             => '1830002',
            //     'password'          => bcrypt('secret'),
            //     'view_password'     => 'secret',
            //     'slug'              => 'mario-santillan',
            //     'created_at'        => '2018-08-10 14:27:56',
            //     'updated_at'        => '2018-08-10 14:27:56',
            //     'remember_token'    => str_random(10),
            // ],
            // 2 => [
            //     'id'                => 3,
            //     'role_id'           => \App\Role::PROFESOR,
            //     'name'              => 'Silvia',
            //     'lastName'          => 'Martinez',
            //     'email'             => 'silvia@gmail.com',
            //     'clave'             => '18320001',
            //     'password'          => bcrypt('secret'),
            //     'view_password'     => 'secret',
            //     'slug'              => 'silvia-martinez',
            //     'created_at'        => '2018-08-10 14:27:56',
            //     'updated_at'        => '2018-08-10 14:27:56',
            //     'remember_token'    => str_random(10),
            // ],
            // 3 => [
            //     'id'                => 4,
            //     'role_id'           => \App\Role::PROFESOR,
            //     'name'              => 'Javier',
            //     'lastName'          => 'Ortega',
            //     'email'             => 'javiortega@gmail.com',
            //     'clave'             => '18320002',
            //     'password'          => bcrypt('secret'),
            //     'view_password'     => 'secret',
            //     'slug'              => 'javier-ortega',
            //     'created_at'        => '2018-08-10 14:27:56',
            //     'updated_at'        => '2018-08-10 14:27:56',
            //     'remember_token'    => str_random(10),
            // ],
            // 4 => [
            //     'id'                => 5,
            //     'role_id'           => \App\Role::PROFESOR,
            //     'name'              => 'Alejandra',
            //     'lastName'          => 'Montes',
            //     'email'             => 'alejandra@gmail.com',
            //     'clave'             => '18320003',
            //     'password'          => bcrypt('secret'),
            //     'view_password'     => 'secret',
            //     'slug'              => 'alejandra-montes',
            //     'created_at'        => '2018-08-10 14:27:56',
            //     'updated_at'        => '2018-08-10 14:27:56',
            //     'remember_token'    => str_random(10),
            // ],
            // 5 => [
            //     'id'                => 6,
            //     'role_id'           => \App\Role::PROFESOR,
            //     'name'              => 'Jaime',
            //     'lastName'          => 'Gomez',
            //     'email'             => 'jaimegomez@gmail.com',
            //     'clave'             => '18320004',
            //     'password'          => bcrypt('secret'),
            //     'view_password'     => 'secret',
            //     'slug'              => 'jaime-gomez',
            //     'created_at'        => '2018-08-10 14:27:56',
            //     'updated_at'        => '2018-08-10 14:27:56',
            //     'remember_token'    => str_random(10),
            // ],
            0 => [
                'id'                => 1,
                'role_id'           => \App\Role::ADMINISTRADOR,
                'name'              => 'Alicia',
                'lastName'          => 'Ortiz Montes',
                'email'             => 'alicia@gmail.com',
                'clave'             => 'ADM01',
                'password'          => bcrypt('secret'),
                'view_password'     => 'secret',
                'slug'              => 'alicia-ortiz-montes',
                'created_at'        => '2018-11-26 13:00:00',
                'updated_at'        => '2018-11-26 13:00:00',
                'remember_token'    => str_random(10),
            ],
            1 => [
                'id'                => 2,
                'role_id'           => \App\Role::ADMINISTRADOR,
                'name'              => 'Marco Tulio',
                'lastName'          => 'Valdez',
                'email'             => 'marcotulio@gmail.com',
                'clave'             => 'ADM02',
                'password'          => bcrypt('secret'),
                'view_password'     => 'secret',
                'slug'              => 'marco-tulio-valdez',
                'created_at'        => '2018-11-26 13:00:00',
                'updated_at'        => '2018-11-26 13:00:00',
                'remember_token'    => str_random(10),
            ],
        ]);

        // \DB::table('students')->insert([
        //     0 => [
        //         'id'            => 1,
        //         'user_id'       => 1,
        //         'cuatrimestre'  => 4,
        //         'carrera'       => 'Ingeniería en software',
        //         'domicilio'     => 'Justo Sierra Av. Emiliano',
        //         'telefono'      => '7712288276',
        //     ],
        //     1 => [
        //         'id'            => 2,
        //         'user_id'       => 2,
        //         'cuatrimestre'  => 8,
        //         'carrera'       => 'Ingeniería en biomédica',
        //         'domicilio'     => 'Miguel Hidalgo Av. Francisco Villa',
        //         'telefono'      => '5546781233',
        //     ],
        // ]);

        // \DB::table('teachers')->insert([
        //     0 => [
        //         'id'         => 1,
        //         'user_id'    => 3,
        //         'profesion'  => 'Ingeniero en software',
        //     ],
        //     1 => [
        //         'id'         => 2,
        //         'user_id'    => 4,
        //         'profesion'  => 'Licenciado',
        //     ],
        //     2 => [
        //         'id'         => 3,
        //         'user_id'    => 5,
        //         'profesion'  => 'Licenciado',
        //     ],
        //     3 => [
        //         'id'         => 4,
        //         'user_id'    => 6,
        //         'profesion'  => 'Ingeniero en Telematica',
        //     ],
        // ]);

        \DB::table('administrators')->insert([
            0 => [
                'id'        => 1,
                'user_id'   => 1,
            ],
            1 => [
                'id'        => 2,
                'user_id'   => 2,
            ],
        ]);
        //3 diferentes niveles
        // factory(\App\Level::class, 1)->create(['nivel'=>'Principiante']);
        // factory(\App\Level::class, 1)->create(['nivel'=>'Intermedio']);
        // factory(\App\Level::class, 1)->create(['nivel'=>'Avanzado']);

        // factory(\App\Course::class, 1)
        //     ->create([
        //         'administrator_id'  => 1, 
        //         'teacher_id'        => 1, 
        //         'level_id'          => \App\Level::all()->random()->id,
        //         'prioridad'         => 1
        //     ])
        //  ->each(
        //         function(\App\Course $curso){
        //        $curso->lessons()
        //             ->saveMany(factory(\App\Lesson::class, 5)
        //             ->create()
        //                 ->each(
        //                     function(\App\Lesson $lesson){
        //                         $lesson->questions()
        //                             ->saveMany(factory(\App\Question::class, 4)
        //                             ->create()
        //                             ->each(
        //                                 function(\App\Question $question){
        //                                     $question->answers()
        //                                     ->saveMany(factory(\App\Answer::class, 3)
        //                                     ->create());
        //                                 }
        //                             ));
        //                 }));
        //     $curso->objectives()->saveMany(factory(\App\Objective::class, 4)->create());
        //  });

        //  factory(\App\Course::class, 1)
        //     ->create([
        //         'administrator_id'  => 2, 
        //         'teacher_id'        => 2, 
        //         'level_id'          => \App\Level::all()->random()->id,
        //         'prioridad'         => 2
        //     ])
        //  ->each(
        //         function(\App\Course $curso){
        //        $curso->lessons()
        //             ->saveMany(factory(\App\Lesson::class, 5)
        //             ->create()
        //                 ->each(
        //                     function(\App\Lesson $lesson){
        //                         $lesson->questions()
        //                             ->saveMany(factory(\App\Question::class, 4)
        //                             ->create()
        //                             ->each(
        //                                 function(\App\Question $question){
        //                                     $question->answers()
        //                                     ->saveMany(factory(\App\Answer::class, 3)
        //                                     ->create());
        //                                 }
        //                             ));
        //                 }));
        //     $curso->objectives()->saveMany(factory(\App\Objective::class, 4)->create());
        //  });

        //  factory(\App\Course::class, 1)
        //     ->create([
        //         'administrator_id'  => 1, 
        //         'teacher_id'        => 3, 
        //         'level_id'          => \App\Level::all()->random()->id,
        //         'prioridad'         => 3
        //     ])
        //  ->each(
        //         function(\App\Course $curso){
        //        $curso->lessons()
        //             ->saveMany(factory(\App\Lesson::class, 5)
        //             ->create()
        //                 ->each(
        //                     function(\App\Lesson $lesson){
        //                         $lesson->questions()
        //                             ->saveMany(factory(\App\Question::class, 4)
        //                             ->create()
        //                             ->each(
        //                                 function(\App\Question $question){
        //                                     $question->answers()
        //                                     ->saveMany(factory(\App\Answer::class, 3)
        //                                     ->create());
        //                                 }
        //                             ));
        //                 }));
        //     $curso->objectives()->saveMany(factory(\App\Objective::class, 4)->create());
        //  });

        //  factory(\App\Course::class, 1)
        //     ->create([
        //         'administrator_id'  => 2, 
        //         'teacher_id'        => 4, 
        //         'level_id'          => \App\Level::all()->random()->id,
        //         'prioridad'         => 4
        //     ])
        //  ->each(
        //         function(\App\Course $curso){
        //        $curso->lessons()
        //             ->saveMany(factory(\App\Lesson::class, 5)
        //             ->create()
        //                 ->each(
        //                     function(\App\Lesson $lesson){
        //                         $lesson->questions()
        //                             ->saveMany(factory(\App\Question::class, 4)
        //                             ->create()
        //                             ->each(
        //                                 function(\App\Question $question){
        //                                     $question->answers()
        //                                     ->saveMany(factory(\App\Answer::class, 3)
        //                                     ->create());
        //                                 }
        //                             ));
        //                 }));
        //     $curso->objectives()->saveMany(factory(\App\Objective::class, 4)->create());
        //  });

        // //2 usuarios como administradores y cada uno con sus datos
        // factory(\App\User::class, 2)->create(['role_id' => \App\Role::ADMINISTRADOR])
        //     ->each(function(\App\User $user){
        //         factory(\App\Administrator::class, 1)->create(['user_id' => $user->id]);
        //     });

        // //20 usuarios como maestros y cada uno con sus datos
        // factory(\App\User::class, 20)->create(['role_id' => \App\Role::PROFESOR])
        //     ->each(function(\App\User $user){
        //         factory(\App\Teacher::class, 1)->create(['user_id' => $user->id]);
        //     });

        // //20 usuarios como estudiantes y cada uno con sus metas
        // factory(\App\User::class, 20)->create(['role_id' => \App\Role::ESTUDIANTE])
        // 	->each(function(\App\User $user){
        // 		factory(\App\Student::class, 1)->create(['user_id' => $user->id])
        // 			->each(function(\App\Student $e){
        // 				factory(\App\Goal::class, 3)->create(['student_id' => $e->id]);
        // 			});
        // 	});
        // //3 diferentes niveles
        // factory(\App\Level::class, 1)->create(['nivel'=>'Principiante']);
        // factory(\App\Level::class, 1)->create(['nivel'=>'Intermedio']);
        // factory(\App\Level::class, 1)->create(['nivel'=>'Avanzado']);
        
        // //10 cursos con 5 lecciones cada uno
        // factory(\App\Course::class, 10)
        //     ->create()
        // 	->each(
        //         function(\App\Course $curso){
        // 		  $curso->lessons()
        //             ->saveMany(factory(\App\Lesson::class, 5)
        //             ->create()
        //                 ->each(
        //                     function(\App\Lesson $lesson){
        //                         $lesson->questions()
        //                             ->saveMany(factory(\App\Question::class, 1)
        //                             ->create()
        //                             ->each(
        //                                 function(\App\Question $question){
        //                                     $question->answers()
        //                                     ->saveMany(factory(\App\Answer::class, 4)
        //                                     ->create());
        //                                 }
        //                             ));
        //                 }));
        // 		$curso->objectives()->saveMany(factory(\App\Objective::class, 4)->create());
        // 	});

        // //Crear una conversación
        // factory(\App\Conversation::class, 1)->create();
    }
}

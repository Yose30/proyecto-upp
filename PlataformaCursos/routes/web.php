<?php

//Vista principal
Route::get('/', function () {
    return view('welcome');
}); 

//Ruta para login y register, para que el usuario se pueda autenticar
Auth::routes(); 
 
Route::post('/pre_register', 'PreRegisterController@store')->name('pre_register');

//Grupo de rutas para mostrar todo lo relacionado a los cursos
Route::group(['prefix' => 'courses', "middleware" => ['auth']], function(){
	//Ruta para el ADMINISTRADOR
	Route::group(['middleware' => [sprintf("role:%s", \App\Role::ADMINISTRADOR)]], function(){
		//Obtener las lecciones de un curso
		Route::get('/{slug}/lessons', 'CourseController@lessons')->name('courses.lessons');
		//Formulario para crear el cursos
		Route::get('/create', 'CourseController@create')->name('courses.create');
		//Guardar un curso
		Route::post('/store', 'CourseController@store')->name('courses.store');
		//Editar cursos
		Route::get('/edit/{slug}', 'CourseController@edit')->name('courses.edit');
		Route::put('/update/{course}', 'CourseController@update')->name('courses.update');
		Route::delete('/delete/{id}', 'CourseController@delete')->name('courses.delete');
		Route::get('/{id}/enrolled_students', 'CourseController@enrolled_students')->name('courses.enrolled_students');
	});
	//Rutas para el ESTUDIANTE
	Route::group(['middleware' => [sprintf("role:%s", \App\Role::ESTUDIANTE)]], function(){
		//SITUAR AL ULTIMO PARA QUE LO PRIMERO SE PUEDA MOSTRAR
		Route::get('/registered_courses', 'CourseController@registered_courses')->name('courses.registered_courses');
		//Mostrar cursos que el alumnos a cursado o esta cursando
		Route::get('/{slug}', 'CourseController@course_details')->name('courses.course_details');
		//Detalles de cada curso
		Route::get('/valoracion/{id}', 'CourseController@valoracion')->name('courses.valoracion');
		Route::post('/add_review', 'CourseController@add_review')->name('courses.add_review');
		//Para valorar un curso
		Route::get('/finished/{id}', 'CourseController@course_finished')->name('courses.finished');
		Route::get('/question/{id}/{opportunity}', 'CourseController@question')->name('courses.question');
		Route::post('/validate', 'CourseController@validate_question')->name('courses.validate');
		Route::get('/send_notification/{course}', 'CourseController@send_notification')->name('courses.send_notification');
		Route::get('/{course}/inscribe', 'CourseController@inscribe')->name('student.inscribe');
		//Para inscribirse en un curso
	});
}); 

Route::group(["prefix" => "lessons", "middleware" => ['auth']], function(){
	Route::group(['middleware' => [sprintf("role:%s", \App\Role::ADMINISTRADOR)]], function(){
		Route::get('/create/{slug}', 'LessonController@create')->name('lessons.create');
		Route::post('/store', 'LessonController@store')->name('lessons.store');
		Route::get('/edit/{id}', 'LessonController@edit')->name('lessons.edit');
		Route::put('/update/{lesson}', 'LessonController@update')->name('lessons.update');
		Route::delete('/delete/{id}', 'LessonController@delete')->name('lessons.delete');

		Route::get('/details/{id}', 'LessonController@details_for_admin')->name('lessons.details');
		
		Route::get('/answers/{id}', 'LessonController@edit_answers')->name('lessons.answers');
		Route::post('/answers_store', 'LessonController@answers_store')->name('lessons.answers_store');
		Route::put('/answers_update/{id}', 'LessonController@answers_update')->name('lessons.answers_update');
	});

	Route::group(['middleware' => [sprintf("role:%s", \App\Role::ESTUDIANTE)]], function(){
		Route::get('/{id}', 'LessonController@lesson_detail')->name('lessons.lesson');
		//Ruta para mostrar detalles de una lección, pasandole el slug como parametro
		Route::get('/{id}/question', 'LessonController@question')->name('lessons.question');
		//Ruta para ir a la actividad
		Route::post('/validate', 'LessonController@validate_question')->name('lessons.validate');
	});
});

Route::group(['middleware' => 'auth'], function(){
	Route::post('/files', 'FileController@store')->name('files.store');
	Route::delete('/files/{file}', 'FileController@destroy')->name('files.destroy');
	Route::get('/files/{file}/download', 'FileController@download')->name('files.download');
});

//Grupo de rutas para ingresar al perfil del usuario
Route::group(["prefix" => "profile", "middleware" => ["auth"]], function(){
	Route::get('/{slug}/edit', 'ProfileController@edit')->name('profile.edit');
	//Ruta para mostrar los datos a editar perfil
	Route::put('/update_password', 'ProfileController@update_password')->name('profile.update_password');
	//Ruta para cambiar contraseña
	Route::put('{user}/update_image', 'ProfileController@update_image')->name('profile.update_image');
	//Ruta para cambiar foto de perfil
	Route::put('{user}/update_email', 'ProfileController@update_email')->name('profile.update_email');
	//Ruta para cambiar email
	Route::get('/email/verify/{code}', 'ProfileController@verify_email')->name('profile.email.verify');
	//STUDENTS
	Route::group(['middleware' => [sprintf("role:%s", \App\Role::ESTUDIANTE)]], function(){
		Route::post('/{user}/store', 'ProfileController@store')->name('profile.store');
		//Ruta para guardar datos de perfil
		Route::put('/{user}/update', 'ProfileController@update')->name('profile.update');
		//Ruta para actualizar perfil
	});
	//TEACHER
	Route::group(['middleware' => [sprintf("role:%s", \App\Role::PROFESOR)]], function(){
		Route::put('/update_biography', 'ProfileController@update_biography')->name('profile.update_biography');
		Route::put('/update_curriculum', 'ProfileController@update_curriculum')->name('profile.update_curriculum');
	});
	//ADMINISTRADOR
	Route::group(['middleware' => [sprintf("role:%s", \App\Role::ADMINISTRADOR)]], function(){
		Route::delete('/{id}/destroy_user', 'ProfileController@destroy_user')->name('profile.destroy_user');
		Route::get('/restore_user/{id}', 'ProfileController@restore_user')->name('profile.restore_user');
	});
	//Ruta para ver el perfil entre todos los usuarios
	Route::get('/{id}/{slug}', 'ProfileController@profile')->name('profile.profile');
});

//Grupo de rutas para el profesor
Route::group(["prefix" => "teacher", 'middleware' => 'auth'], function(){
	Route::group(['middleware' => [sprintf("role:%s", \App\Role::ADMINISTRADOR)]], function(){
		//Guardad los datos de un nuevo profesor
		Route::post('/store', 'TeacherController@store')->name('teacher.store');
	});
	Route::group(['middleware' => [sprintf("role:%s", \App\Role::PROFESOR)]], function(){
		//Mostrar los cursos asignados del profesor
		Route::get('courses/assigned', 'TeacherController@my_courses')->name('teacher.courses.assigned');
		//Mostrar los detalles del curso
		Route::get('/{slug}', 'TeacherController@details')->name('teacher.courses.details');
		//Mostrar los detalles del curso
		Route::get('courses/{id}/students', 'TeacherController@enrolled_students')->name('teacher.courses.enrolled_students');
		Route::get('courses/lesson/{id}', 'TeacherController@lesson')->name('teacher.courses.lesson');
		Route::post('/send_email_low', 'TeacherController@send_email_low')->name('teacher.send_email_low');
	});
});

//Rutas para los mensajes
Route::post('/messages', 'MessageController@sentMessage')->middleware('auth');
Route::get('/all_conversations', 'MessageController@all_conversations')->name('conversations.all_conversations')->middleware('auth');
//Chat del estudiante para enviarle mensaje al profesor
Route::get('/conversations/chat_student/{id}', 
	'MessageController@sent_messagge_to_teacher')->name('conversations.chat_student')->middleware('auth');
//Chat del profesor para enviarle mensaje al estudiante
Route::get('/conversations/chat_teacher/{id}', 
	'MessageController@sent_messagge_to_user')->name('conversations.chat_teacher')->middleware('auth');
//Chat del administrador para enviarle mensaje al profesor
Route::get('/conversations/chat_admin/{id}', 
	'MessageController@messagge_to_teacher')->name('conversations.chat_admin')->middleware('auth');
Route::get('/messages', 'MessageController@fetch')->middleware('auth');

//Grupo de rutas para el administrador
Route::group(['prefix' => 'admin', "middleware" => ['auth', sprintf("role:%s", \App\Role::ADMINISTRADOR)]], function(){
	//Mostrar los cursos existentes junto con sus datos, al administrador
	Route::get('/inicio', 'AdministratorController@inicio')->name('admin.inicio');
	Route::get('/courses_json', 'AdministratorController@coursesJson')->name('admin.courses_json');
	Route::get('/updateEstado/{course_id}', 'AdministratorController@updateCourseEstado')->name('admin.updateEstado');
	Route::get('/pre_register', 'AdministratorController@pre_register')->name('admin.pre_register');
	Route::post('/approve_student', 'AdministratorController@approve_student')->name('admin.approve_student');
	Route::delete('/delete_student/{id}', 'AdministratorController@delete_student')->name('admin.delete_student');
	Route::get('/users', 'AdministratorController@get_users')->name('admin.users');
	Route::get('/students', 'AdministratorController@students')->name('admin.students');
	Route::get('/students_inactive', 'AdministratorController@students_inactive')->name('admin.students_inactive');
	Route::get('/teachers', 'AdministratorController@teachers')->name('admin.teachers');
	Route::get('/courses', 'AdministratorController@courses')->name('admin.courses');
	//Ruta para cambiar el estado del curso del estudiante
	Route::get('/change_status/{course_id}/{student_id}', 'AdministratorController@change_status')->name('admin.change_status');
	//Ruta para reiniciar avance del curso
	Route::get('/restart_progress/{course_id}/{student_id}', 'AdministratorController@restart_progress')->name('admin.restart_progress');
	//Ruta para dar mantenimiento
	Route::get('/mantenimiento', 'AdministratorController@mantenimiento')->name('admin.mantenimiento');
	Route::delete('/remove_status/{id}', 'AdministratorController@remove_status')->name('admin.remove_status');
});


//Ruta para poder ver la imagen del curso
Route::get('/images/{path}/{attachment}', function($path, $attachment){
	$file = sprintf('storage/%s/%s', $path, $attachment); //Indica donde se encuentra la imagen pasando como parametros el directoro y el nombre de la imagen
	if (File::exists($file)) {
		return Image::make($file)->response();
	} //\Intervention\Image\Facade\
}); //Ruta para mostrar las imagenes de los cursos


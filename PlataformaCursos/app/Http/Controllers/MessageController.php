<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSentEvent;
use App\Message;
use App\Conversation;
use App\Student;
use App\Course;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewMessageChat;

class MessageController extends Controller 
{
    //Función para que el usuario pueda obtener todas sus conversaciones
    public function all_conversations(){
        if (auth()->user()->role_id == Role::PROFESOR) {
            $conversations = Conversation::where('teacher_id', auth()->user()->teacher->id)->get();
            $users = User::all();
        }
        else{
            $users = User::where('role_id', Role::PROFESOR)->get();
            $conversations = Conversation::where('user_id', auth()->user()->id)->get();
        }
        return view('conversations.all_conversations', compact('conversations', 'users'));
    }

    //Función para que el adminstrador le envie mensaje al profesor
    public function messagge_to_teacher($id){
        $conversations = Conversation::where('user_id', auth()->user()->id)->get();
        $users = User::where('role_id', Role::PROFESOR)->get();
        $conversation = Conversation::where([['user_id', auth()->user()->id], ['teacher_id', $id]])->with('user', 'teacher')->first();
        
        //Marcar como leidos los mensajes, al momento de entrar a la conversación
        foreach (auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewMessageChat') as $notification) {
            if ($notification->data['conversation']['id'] == $conversation->id) {
                $notification->markAsRead();
                $notification->delete();
            }
        }
        
        return view('conversations.chat_admin', compact('conversation', 'conversations', 'users'));
    }

    //Función para enviar mensaje al profesor, en esta función solo el estudiante puede mandarle mensaje
    public function sent_messagge_to_teacher($id){
        $conversations = Conversation::where('user_id', auth()->user()->id)->get();
        $conversation = Conversation::where([['user_id', auth()->user()->id], ['teacher_id', $id]])->with('user', 'teacher')->first();
        $course = \DB::table('course_student')->where([
            ['student_id', auth()->user()->student->id], 
            ['situacion', Course::CURSANDO]
        ])->first();
        $users = User::where('role_id', Role::PROFESOR)->get();

        //Marcar como leidos los mensajes, al momento de entrar a la conversación
        foreach (auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewMessageChat') as $notification) {
            if ($notification->data['conversation']['id'] == $conversation->id) {
                $notification->markAsRead();
                $notification->delete();
            }
        }

        return view('conversations.chat_student', compact('conversation', 'course', 'conversations', 'users'));
    } 

    //Función para enviar mensaje al estudiante, solo el profesor puede mandarle mensaje a el estudiante
    public function sent_messagge_to_user($id){
        $conversations = Conversation::where('teacher_id', auth()->user()->teacher->id)->get();
        $conversation = Conversation::where([['user_id', $id], ['teacher_id', auth()->user()->teacher->id]])->with('user')->first(); 
        $student = Student::where('user_id', $id)->first();
        $course = NULL;
        if($student != NULL){
            $course = \DB::table('course_student')->where([
                ['student_id', $student->id], 
                ['situacion', Course::CURSANDO]
            ])->first();
        }
        $users = User::all();
        //Marcar como leidos los mensajes, al momento de entrar a la conversación
        foreach (auth()->user()->unreadNotifications->where('type', 'App\Notifications\NewMessageChat') as $notification) {
            if ($notification->data['conversation']['id'] == $conversation->id) {
                $notification->markAsRead();
                $notification->delete();
            }
        }
        
      return view('conversations.chat_teacher', compact('conversation', 'course', 'conversations', 'users'));
    }

    public function fetch(){
        return Message::with('user')->get();
    }

    public function sentMessage(Request $request){
        $conversation = Conversation::find($request->conversation_id);
        $message = Message::create([
            'conversation_id' =>$conversation->id,
            'user_id' => auth()->user()->id,
            'message' => $request->message
        ]);

        if (auth()->user()->role_id == Role::PROFESOR) {
            $user = User::find($conversation->user_id);
        }
        else{
            $user = User::find($conversation->teacher->user_id);
        }

        $user->notify(new NewMessageChat($message, $conversation));

        broadcast(new MessageSentEvent(auth()->user(), $message, $conversation_id))->toOthers();
    }
}

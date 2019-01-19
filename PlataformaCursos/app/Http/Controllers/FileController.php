<?php

namespace App\Http\Controllers;

use App\File;
use Spatie\Dropbox\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function __construct(){
        // Necesitamos obtener una instancia de la clase Client la cual tiene algunos métodos
        // que serán necesarios.
        $this->dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();   
    }

    public function store(Request $request){
    	//Validamos el tipo de archivo que se subira
    	$validator = Validator::make($request->all(), [
            'file' => 'required|mimes:pdf,jpg,jpeg,png,xls,xlsx,doc,docx|max:3000',
            'titulo' => 'required|string|max:50|unique:files',
            'descripcion' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return back()->with('message', ['danger', __('Error al cargar archivo, intente de nuevo por favor')]);
        }else{
	        try {
                if(Storage::disk('dropbox')->exists('/Aplicaciones/files/'.$request->file('file')->getClientOriginalName())){
                    return back()->with('message', ['danger', __('El archivo ya existe')]);
                }
                else{
                    \DB::beginTransaction();
                    // Guardamos el archivo indicando el driver y el método putFileAs el cual recibe
                    // el directorio donde será almacenado, el archivo y el nombre.
                    // ¡No olvides validar todos estos datos antes de guardar el archivo!

                    Storage::disk('dropbox')->putFileAs(
                        '/Aplicaciones/files/', 
                        $request->file('file'), 
                        $request->file('file')->getClientOriginalName()
                    );

                    // Creamos el enlace publico en dropbox utilizando la propiedad dropbox
                    // definida en el constructor de la clase y almacenamos la respuesta.
                    $response = $this->dropbox->createSharedLinkWithSettings(
                        '/Aplicaciones/files/'.$request->file('file')->getClientOriginalName(), 
                        ["requested_visibility" => "public"]
                    ); 

                    // Creamos un nuevo registro en la tabla files con los datos de la respuesta.
                    File::create([
                        'user_id' => auth()->id(),
                        'lesson_id' => $request->input('lesson_id'),
                        'titulo' => $request->input('titulo'),
                        'descripcion' => $request->input('descripcion'),
                        'name' => $response['name'],
                        'extension' => $request->file('file')->getClientOriginalExtension(),
                        'size' => $response['size'],
                        'public_url' => $response['url']
                    ]);
                    
                    $success = true;
                }
            } catch (Exception $e) {
                \DB::rollBack();
                $success = $exception->getMessage();
            }

            if ($success === true) {
                \DB::commit();
                // Retornamos un redirección hacía atras
                return back()->with('message', ['success', __("Archivo subido correctamente")]);
            }
            return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    	}
    }

    public function destroy(File $file){
        try {
            \DB::beginTransaction();
            // Eliminamos el archivo en dropbox llamando a la clase
            // instanciada en la propiedad dropbox.
            $this->dropbox->delete('/Aplicaciones/files/'.$file->name);
            // Eliminamos el registro de nuestra tabla.
            $file->delete();
            $success = true;
        } catch (Exception $e) {
            \DB::rollBack();
            $success = $exception->getMessage();
        }
        if ($success === true) {
            \DB::commit();
            return back()->with('message', ['success', __("Eliminado correctamente")]);
        }
        return back()->with('message', ['danger', __("Ocurrió un error, vuelve a intentarlo por favor")]);
    }

    public function download(File $file){
        // Retornamos una descarga especificando el driver dropbox
        // e indicándole al método download el nombre del archivo.
        return Storage::disk('dropbox')->download('/Aplicaciones/files/'.$file->name);
    }
}

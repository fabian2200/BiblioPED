<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Illuminate\Http\Request;
use DB;
use Jenssegers\Mongodb\Facades\MongoDB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

require 'conexion.php';

class FavoritosController extends Controller
{

    protected static $mongoClient;
    protected static $mongoDB;

    public function __construct()
    {
        $instanciaConexion = new ClaseConexion();

        if (!isset(self::$mongoClient)) {
            self::$mongoClient = $instanciaConexion::$mongoClient;
        }

        if (!isset(self::$mongoDB)) {
            self::$mongoDB = $instanciaConexion::$mongoDB;
        }
    }

    public function agregarFavorito(Request $request){
        
        
        $collection = self::$mongoDB->selectCollection('favoritos');

        $idUsuario = Session::get('id');

        if (Session::has('id')) {
            $id_contenido = $request->input('id');
            $titulo = $request->input('titulo');
            $ruta = $request->input('ruta');
    
            $favorito = [
                'id_usuario' => Session::get('id'),
                'id_contenido' => $id_contenido,
                'titulo' => $titulo,
                'ruta' => $ruta,
                'fecha' => date('Y-m-d'),
            ];
    
            $collection->insertOne($favorito);

            return response()->json(['¡Agregado a favoritos correctamente!', 1], 200);
        }else{
            return response()->json(['¡Debe iniciar sesión primero!', 0], 200);
        }
    }

    public function BuscarFavorito(Request $request){
        
        
        $collection = self::$mongoDB->selectCollection('favoritos');

        $idUsuario = Session::get('id');

        if (Session::has('id')) {
            $id_contenido = $request->input('id');

            $condiciones = [
                'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
                'id_contenido' => (int)$id_contenido,
            ];
        
            // Ejecuta la consulta y obtén el conteo de registros
            $conteo = $collection->countDocuments($condiciones);

            if($conteo == 0){
                $ok = false;
            }else{  
                $ok = true;
            }

            return response()->json($ok, 200);
        }else{
            return response()->json(false, 200);
        }
    }

    public function EliminarFavorito(Request $request){
        
        
        $collection = self::$mongoDB->selectCollection('favoritos');

        $idUsuario = Session::get('id');

        if (Session::has('id')) {
            $id_contenido = $request->input('id');

            $condiciones = [
                'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
                'id_contenido' => (int)$id_contenido,
            ];
        
            // Ejecuta la consulta y obtén el conteo de registros
            $conteo = $collection->deleteOne($condiciones);

            return response()->json("¡Eliminado de mis favoritos correctamente!", 200);
        }
        
    }

    public function MisFavoritos(Request $request){
        
        $collection = self::$mongoDB->selectCollection('favoritos');

        $idUsuario = Session::get('id');

        if (Session::has('id')) {
            $texto = $request->input('texto');

            if($texto == "todo"){
                $condiciones = [
                    'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
                ];
            }else{
                $condiciones = [
                    'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
                    'titulo' => ['$regex' => $texto, '$options' => 'i']
                ];
            }

            $conteo = $collection->find($condiciones)->toArray();

            return response()->json($conteo, 200);
        }else {
            return response()->json([], 200);
        }
    }

    public function eliminarFavoritos(Request $request){
        $collection = self::$mongoDB->selectCollection('favoritos');

        $tipo_borrado = $request->input('tipo_borrado');
        $ids_eliminar = $request->input('ids_eliminar');
        $idUsuario = Session::get('id');

        if($tipo_borrado == "todo"){
            $condiciones = [
                'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
            ];

            $conteo = $collection->deleteMany($condiciones);

            return response()->json("¡Todos los registros de favoritos fueron eliminados correctamente!", 200);
        }else{
            $ids_eliminar = array_map(function ($id) {
                return new \MongoDB\BSON\ObjectID($id);
            }, $ids_eliminar);
            
            $condiciones = [
                '_id' => ['$in' => $ids_eliminar]
            ];
              
            $result = $collection->deleteMany($condiciones);

            return response()->json("Se eliminaron ".$result->getDeletedCount()." favoritos.", 200);
        }
    }
}

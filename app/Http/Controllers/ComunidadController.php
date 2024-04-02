<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Illuminate\Http\Request;
use DB;

use Jenssegers\Mongodb\Facades\MongoDB;

use HTMLPurifier;
use HTMLPurifier_Config;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

require 'conexion.php';

class ComunidadController extends Controller
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

    public function guardarPublicacion(Request $request){
        
        //$uri = "mongodb+srv://fabian:cuentafalsa17@cluster0.5dxsgxo.mongodb.net/?retryWrites=true&w=majority";
        //$mongoClient = new Client($uri);

        $collection = self::$mongoDB->selectCollection('publicaciones');

        $idUsuario = Session::get('id');
        $detalle = $request->input('detalle');

        
        $multimedia = $request->file('imagen');
        $nombreArchivo  = "";

        if ($multimedia !== null) {
            $nombreArchivo = $multimedia->getClientOriginalName();
            $multimedia->move(public_path('imagenes_comunidad'), $nombreArchivo);
        }
       
        $timezone = new \DateTimeZone('America/Bogota');

        $fechaActual = new \DateTime('now', $timezone);
        $horaActual = new \DateTime('now', $timezone);

        $elemento_ingresar = [
            'id_usuario' => Session::get('id'),
            'detalle' => $detalle,
            'imagen' => $nombreArchivo,
            'comentarios' => [],
            'likes' => [],
            'fecha' => $fechaActual->format('d/m/Y'),
            'horas' => $horaActual->format('H:i:s'),
        ];

        $resultado = $collection->insertOne($elemento_ingresar);

        if ($resultado->getInsertedCount() === 1) {
            return response()->json(["¡Su publicación fue publicada correctamente!", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }
    }

    public function infoPost(Request $request){
        $collection = self::$mongoDB->selectCollection('publicaciones');
        $collection2 = self::$mongoDB->selectCollection('usuarios');

        $id = $request->input('id');
        $idUsuario = (string) Session::get('id');

        $publicacion = $collection->find([
            '_id' => new \MongoDB\BSON\ObjectID($id),
        ])->toArray();

        $publicacion = $publicacion[0];

        if(in_array($idUsuario, json_decode(json_encode($publicacion->likes)))){
            $publicacion->like = true;
        }else{
            $publicacion->like = false;
        }

        $publicacion->usuario = $collection2->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($publicacion->id_usuario),
        ]);

        $comentarios = $publicacion->comentarios;
        if(count($comentarios) > 0){
            $comentarios = iterator_to_array($publicacion['comentarios']);
            usort($comentarios, function($a, $b) {
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                return $dateTimeB <=> $dateTimeA; 
            });  
            
            $publicacion->comentarios = $comentarios;
        }

        $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $publicacion['fecha'] . ' ' . $publicacion['horas'], new \DateTimeZone('America/Bogota'));

        $publicacion->fecha_formateada = $dateTimeA->format('d M, Y \a\ \l\a\s g.i A');

        if (property_exists($publicacion, 'editado')){
            $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $publicacion['fecha_edicion'] . ' ' . $publicacion['horas_edicion'], new \DateTimeZone('America/Bogota'));
            $publicacion->fecha_formateada_edicion = $dateTimeB->format('d M, Y \a\ \l\a\s g.i A');
        }

        foreach ($publicacion->comentarios as $comentario){
            $comentario->usuario = $collection2->findOne([
                '_id' => new \MongoDB\BSON\ObjectID($comentario->id_usuario),
            ]);

            $fechaHora = $comentario['fecha'] . ' ' . $comentario['horas'];
            $timezone = new \DateTimeZone('America/Bogota');

            $fechaActual = new \DateTime('now', $timezone);
            $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $fechaHora, $timezone);

            $diferencia =(int)$fechaActual->getTimestamp() - (int)$dateTimeA->getTimestamp();

            $fechaFormateada = '';
            if ($diferencia < 60) {
                $fechaFormateada = "Hace un momento";
            } elseif ($diferencia < 3600) {
                $minutos = round($diferencia / 60);
                $fechaFormateada = "Hace {$minutos} minuto(s)";
            } elseif ($diferencia < 86400) {
                $horas = round($diferencia / 3600);
                $fechaFormateada = "Hace {$horas} horas";
            } elseif ($diferencia < 1296000) { 
                $dias = round($diferencia / 86400);
                $fechaFormateada = "Hace {$dias} días";
            } else {
                $fechaFormateada = $dateTimeA->format('d M, Y \a \l\a\s h:i A');
            }

            $comentario->fechaFormateada = $fechaFormateada;

            
            if(in_array($idUsuario, json_decode(json_encode($comentario->likes)))){
                $comentario->like_usuario = 1;
            }else{
                $comentario->like_usuario = 0;
            }

            $comentario->respuestas_comentario = self::respuestasComentarioPost($comentario["_id"]);
            
        }

        $publicacion->usuarios_likes = "";

        foreach ($publicacion->likes as $usuario_like_id) {
            $usuario_like = $collection2->findOne([
                '_id' => new \MongoDB\BSON\ObjectID($usuario_like_id),
            ]);

            $publicacion->usuarios_likes .= '<i style="font-size: 8px" class="fas fa-dot-circle"></i> '.$usuario_like->nombre."<br>";
        }

        return $publicacion;

    }

    public function listarPublicaciones(Request $request){

        $pagina = $request->input('pagina');

        $limit = 5;
    
        if ($pagina == null || $pagina == "") {
            $pagina = 1;
        }
    
        $offset = ($pagina - 1) * $limit;

        $collection = self::$mongoDB->selectCollection('publicaciones');
        $collection2 = self::$mongoDB->selectCollection('usuarios');

        $publicaciones = $collection->find([])->toArray();

        usort($publicaciones, function($a, $b) {
            $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
            $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
            return $dateTimeB <=> $dateTimeA; 
        });  

        $publicaciones = array_slice($publicaciones, $offset, $limit);

        $idUsuario = (string) Session::get('id');

        foreach ($publicaciones as $publicacion) {
            if(in_array($idUsuario, json_decode(json_encode($publicacion->likes)))){
                $publicacion->like = true;
            }else{
                $publicacion->like = false;
            }

            $publicacion->usuario = $collection2->findOne([
                '_id' => new \MongoDB\BSON\ObjectID($publicacion->id_usuario),
            ]);

            $comentarios = $publicacion->comentarios;
            if(count($comentarios) > 0){
                $comentarios = iterator_to_array($publicacion['comentarios']);
                usort($comentarios, function($a, $b) {
                    $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                    $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                    return $dateTimeB <=> $dateTimeA; 
                });  
                
                $publicacion->comentarios = $comentarios;
            }

            $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $publicacion['fecha'] . ' ' . $publicacion['horas'], new \DateTimeZone('America/Bogota'));

            $publicacion->fecha_formateada = $dateTimeA->format('d M, Y \a\ \l\a\s g.i A');

            if (property_exists($publicacion, 'editado')){
                $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $publicacion['fecha_edicion'] . ' ' . $publicacion['horas_edicion'], new \DateTimeZone('America/Bogota'));
                $publicacion->fecha_formateada_edicion = $dateTimeB->format('d M, Y \a\ \l\a\s g.i A');
            }

            foreach ($publicacion->comentarios as $comentario){
                $comentario->usuario = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($comentario->id_usuario),
                ]);

                $fechaHora = $comentario['fecha'] . ' ' . $comentario['horas'];
                $timezone = new \DateTimeZone('America/Bogota');

                $fechaActual = new \DateTime('now', $timezone);
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $fechaHora, $timezone);

                $diferencia =(int)$fechaActual->getTimestamp() - (int)$dateTimeA->getTimestamp();

                $fechaFormateada = '';
                if ($diferencia < 60) {
                    $fechaFormateada = "Hace un momento";
                } elseif ($diferencia < 3600) {
                    $minutos = round($diferencia / 60);
                    $fechaFormateada = "Hace {$minutos} minuto(s)";
                } elseif ($diferencia < 86400) {
                    $horas = round($diferencia / 3600);
                    $fechaFormateada = "Hace {$horas} horas";
                } elseif ($diferencia < 1296000) { 
                    $dias = round($diferencia / 86400);
                    $fechaFormateada = "Hace {$dias} días";
                } else {
                    $fechaFormateada = $dateTimeA->format('d M, Y \a \l\a\s h:i A');
                }

                $comentario->fechaFormateada = $fechaFormateada;

                
                if(in_array($idUsuario, json_decode(json_encode($comentario->likes)))){
                    $comentario->like_usuario = 1;
                }else{
                    $comentario->like_usuario = 0;
                }
                
                $comentario->respuestas_comentario = self::respuestasComentarioPost($comentario["_id"]);
            }

            $publicacion->usuarios_likes = "";

            foreach ($publicacion->likes as $usuario_like_id) {
                $usuario_like = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($usuario_like_id),
                ]);

                $publicacion->usuarios_likes .= '<i style="font-size: 8px" class="fas fa-dot-circle"></i> '.$usuario_like->nombre."<br>";
            }
        }

        return $publicaciones;
    }

    public function registrarComentarioPost(Request $request){
      
        $collection = self::$mongoDB->selectCollection('publicaciones');
        $collectionUsuarios = self::$mongoDB->selectCollection('usuarios');

        $idUsuario = Session::get('id');
        $idPost = $request->input('idPost');
        $comentarioTexto = $request->input('comentarioTexto');
       
        $timezone = new \DateTimeZone('America/Bogota');

        $fechaActual = new \DateTime('now', $timezone);
        $horaActual = new \DateTime('now', $timezone);

        $elemento_ingresar = [
            '_id' => new \MongoDB\BSON\ObjectID(),
            'id_usuario' => Session::get('id'),
            'comentarioTexto' => $comentarioTexto,
            'likes'=> [],
            'fecha' => $fechaActual->format('d/m/Y'),
            'horas' => $horaActual->format('H:i:s'),
        ];

        $resultado = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($idPost)],
            ['$push' => ['comentarios' => $elemento_ingresar]]
        );


        if ($resultado->getModifiedCount() > 0) {
            $collectionUsuarios->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($idUsuario)],
                ['$inc' => ['numero_comentarios' => 1]]
            );

            $publicacion = $collection->findOne([
                '_id' => new \MongoDB\BSON\ObjectID($idPost), 
            ]);
            self::guardarNotificacion((string) $publicacion->id_usuario, (string) $publicacion['_id'], 3);

            return response()->json(["¡Se ha registrado su comentario correctamente!", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }
    }

    public function eliminarComentarioPost(Request $request){
        $collection = self::$mongoDB->selectCollection('publicaciones');
        $collectionUsuarios = self::$mongoDB->selectCollection('usuarios');

        $idUsuario = Session::get('id');

        $id_publicacion = $request->input('id_publicacion');
        $id_comentario = $request->input('id_comentario');

        $result = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id_publicacion)],
            ['$pull' => ['comentarios' => ['_id' => new \MongoDB\BSON\ObjectID($id_comentario)]]]
        );
        
        if ($result->getModifiedCount() > 0) {
            $collectionUsuarios->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectId($idUsuario)],
                ['$inc' => ['numero_comentarios' => -1]]
            );
            return response()->json(["¡Se ha eliminado su comentario correctamente!", 1], 200);
        } else {
            return response()->json(["¡ No se encontró la publicación o el comentario no existe!", 0], 200);
        }
    }

    public function listarUsuariosComunidad(){

        $collection = self::$mongoDB->selectCollection('usuarios');
        $collection2 = self::$mongoDB->selectCollection('publicaciones');

        $usuarios = $collection->find()->toArray();
        $publicaciones = $collection2->find()->toArray();
        
        foreach ($usuarios as $usuario) {
            $usuario->numeroDePublicaciones = $collection2->count(
                ['id_usuario' => $usuario->_id]
            );

            if (property_exists($usuario, 'numero_comentarios')) {
                $usuario->numeroIteraciones = $usuario->numeroDePublicaciones + $usuario->numero_comentarios;
            } else {
                $usuario->numeroIteraciones = $usuario->numeroDePublicaciones;
            }
        }

        $usuarios = collect($usuarios)->sortByDesc('numeroIteraciones')->values()->take(6)->all();

        return $usuarios;
    }

    public function editarPublicacion(Request $request){
       
        $collection = self::$mongoDB->selectCollection('publicaciones');

        $id_publicacion = $request->input('id_publicacion');
        $detalle = $request->input('detalle');
        $multimedia = $request->file('imagen');
        $nombreArchivo  = "";

        if ($multimedia !== null) {
            $nombreArchivo = $multimedia->getClientOriginalName();
            $multimedia->move(public_path('imagenes_comunidad'), $nombreArchivo);
        }

        $timezone = new \DateTimeZone('America/Bogota');

        $fechaActual = new \DateTime('now', $timezone);
        $horaActual = new \DateTime('now', $timezone);

        $resultado = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id_publicacion)], 
            [            
                '$set' => [
                    'detalle' => $detalle,
                    'imagen' => $nombreArchivo,
                    'fecha_edicion' => $fechaActual->format('d/m/Y'),
                    'horas_edicion' => $horaActual->format('H:i:s'),
                    'editado' => true
                ]
            ]
        );

        if ($resultado->getModifiedCount() === 1) {
            return response()->json(["¡Su publicación fue editada correctamente!", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }
    }

    public function eliminarPost(Request $request){
       
        $collection = self::$mongoDB->selectCollection('publicaciones');
        $collectionUsuarios = self::$mongoDB->selectCollection('usuarios');

        $idUsuario = Session::get('id');

        $id_publicacion = $request->input('id_publicacion');

        $result = $collection->deleteOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id_publicacion)],
        );
        
        if ($result->getDeletedCount() > 0) {
            return response()->json(["¡Se ha eliminado su publicación correctamente!", 1], 200);
        } else {
            return response()->json(["¡ No se encontró la publicación que desea eliminar!", 0], 200);
        }
    }

    public function meGusta(Request $request){
       
        $collection = self::$mongoDB->selectCollection('publicaciones');

        $id_usuario = $request->input('id_usuario');
        $id_publicacion = $request->input('id_publicacion');
      
        $documento = $collection->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($id_publicacion), 
            'likes' => $id_usuario
        ]);

        $bandera = false;

        if ($documento) {
            $resultado = $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($id_publicacion)],
                ['$pull' => ['likes' => $id_usuario]]
            );
        } else {
            $bandera = true;
            $resultado = $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($id_publicacion)],
                ['$addToSet' => ['likes' => $id_usuario]]
            );
        }

        if ($resultado->getModifiedCount() > 0) {
            if($bandera){
                $publicacion = $collection->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($id_publicacion), 
                ]);

                self::guardarNotificacion((string) $publicacion->id_usuario, (string) $publicacion['_id'], 2);
            }
            return response()->json(["", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }
    }

    public function guardarNotificacion($id_usuario_publicacion, $id_notificacion, $tipo){
        
        $collection2 = self::$mongoDB->selectCollection('notificaciones');


        $timezone = new \DateTimeZone('America/Bogota');

        $fechaActual = new \DateTime('now', $timezone);
        $horaActual = new \DateTime('now', $timezone);

        $idUsuario = (string) Session::get('id');

        if($id_usuario_publicacion != $idUsuario){
            if($tipo == 2){
                $noti = [
                    'id_usuario' => $id_usuario_publicacion,
                    'ruta' => 'publicacion/'.$id_notificacion,
                    'tema' => '<strong>'.Session::get('nombre').'</strong> ha indicado que le gusta tu publiación',
                    'fecha' => $fechaActual->format('d/m/Y'),
                    'horas' => $horaActual->format('H:i:s'),
                    'estado' => 'cerrado',
                    'tipo' => 2
                ];
            }else{
                if($tipo == 3){
                    $noti = [
                        'id_usuario' => $id_usuario_publicacion,
                        'ruta' => 'publicacion/'.$id_notificacion,
                        'tema' => '<strong>'.Session::get('nombre').'</strong> ha comentado tu publiación',
                        'fecha' => $fechaActual->format('d/m/Y'),
                        'horas' => $horaActual->format('H:i:s'),
                        'estado' => 'cerrado',
                        'tipo' => 3
                    ];
                }else{
                    if($tipo == 22){
                        $noti = [
                            'id_usuario' => $id_usuario_publicacion,
                            'ruta' => 'publicacion/'.$id_notificacion,
                            'tema' => '<strong>'.Session::get('nombre').'</strong> ha indicado que le gusta tu comentario',
                            'fecha' => $fechaActual->format('d/m/Y'),
                            'horas' => $horaActual->format('H:i:s'),
                            'estado' => 'cerrado',
                            'tipo' => 2
                        ]; 
                    }else{
                        $noti = [
                            'id_usuario' => $id_usuario_publicacion,
                            'ruta' => 'publicacion/'.$id_notificacion,
                            'tema' => '<strong>'.Session::get('nombre').'</strong> ha respondido tu comentario',
                            'fecha' => $fechaActual->format('d/m/Y'),
                            'horas' => $horaActual->format('H:i:s'),
                            'estado' => 'cerrado',
                            'tipo' => 3
                        ];
                    }
                }
                
            }
        
            $collection2->insertOne($noti);
        }
       
    }

    public function numeroPost(){
        $collection = self::$mongoDB->selectCollection('publicaciones');
    
        $publicacion = $collection->count();

        return response()->json($publicacion);
    }

    public function meGustaComentario(Request $request){
       
        $collection = self::$mongoDB->selectCollection('publicaciones');

        $id_publicacion = $request->input('id_publicacion');
        $id_comentario = $request->input('id_comentario');
        $idUsuario = (string) Session::get('id');

        $publicacion = $collection->find([
            '_id' => new \MongoDB\BSON\ObjectID($id_publicacion)
        ])->toArray()[0];


        $bandera = false;
        
        $index = 0;
        foreach ($publicacion->comentarios as $key) {
            if((string) $key["_id"] == $id_comentario){
                $comentario = $key;
                break;
            }
            $index++;
        }
              
        $likesArray = json_decode(json_encode($comentario->likes), true);
        $keyInArray = array_search($idUsuario, $likesArray);

        if ($keyInArray !== false) {
            unset($publicacion->comentarios[$index]->likes[$keyInArray]);
        } else {
            $publicacion->comentarios[$index]->likes[] = $idUsuario;
            $bandera = true;
        }

        $resultado = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id_publicacion)],
            ['$set' => ['comentarios' => $publicacion->comentarios]]
        );

        if ($resultado->getModifiedCount() > 0) {
            if($bandera){
                $publicacion = $collection->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($id_publicacion), 
                ]);

                $comentario = null;
                foreach ($publicacion->comentarios as $key) {
                    if((string) $key["_id"] == $id_comentario){
                        $comentario = $key;
                    }
                }
                
                self::guardarNotificacion((string) $comentario->id_usuario, (string) $publicacion['_id'], 22);
            }
            return response()->json(["", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }
    }

    public function guardarRespuestaComentarioPost(Request $request){
        $collectionp = self::$mongoDB->selectCollection('publicaciones');
        $collection = self::$mongoDB->selectCollection('respuesta_comentario_post');
        $collectionUsuarios = self::$mongoDB->selectCollection('usuarios');

        $idUsuario = Session::get('id');
        
        $comentarioTexto = $request->input('comentarioTexto');
        $idComentario = $request->input('idComentario');
        $idPublicacion = $request->input('idPublicacion');
       
        $timezone = new \DateTimeZone('America/Bogota');

        $fechaActual = new \DateTime('now', $timezone);
        $horaActual = new \DateTime('now', $timezone);

        $elemento_ingresar = [
            'id_usuario' => Session::get('id'),
            'comentarioTexto' => $comentarioTexto,
            'idComentario' => $idComentario,
            'idPublicacion' => $idPublicacion,
            'fecha' => $fechaActual->format('d/m/Y'),
            'horas' => $horaActual->format('H:i:s'),
        ];

        $resultado = $collection->insertOne(
           $elemento_ingresar
        );


        if ($resultado->getInsertedCount() > 0) {

            $publicacion = $collectionp->findOne([
                '_id' => new \MongoDB\BSON\ObjectID($idPublicacion), 
            ]);

            $comentario = null;
            foreach ($publicacion->comentarios as $key) {
                if((string) $key["_id"] == $idComentario){
                    $comentario = $key;
                }
            }

            self::guardarNotificacion((string) $comentario->id_usuario, (string) $publicacion['_id'], 33);
            return response()->json(["¡Se ha registrado su respuesta correctamente!", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }
    }

    public function respuestasComentarioPost($id_comentario){

        $collection = self::$mongoDB->selectCollection('respuesta_comentario_post');
        $collection2 = self::$mongoDB->selectCollection('usuarios');

        $respuestas = $collection->find([
            "idComentario" => (string) $id_comentario
        ])->toArray();

        usort($respuestas, function($a, $b) {
            $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
            $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
            return $dateTimeB <=> $dateTimeA; 
        });  

        foreach ($respuestas as $respuesta) {
            $respuesta->usuario = $collection2->findOne([
                '_id' => new \MongoDB\BSON\ObjectID($respuesta->id_usuario),
            ]);
        }

        return $respuestas;
    }

    public function eliminarRespuestaComentario(Request $request){
        $collection = self::$mongoDB->selectCollection('respuesta_comentario_post');

        $id_comentario = $request->input('id_comentario');


        $result = $collection->deleteOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id_comentario)],
        );
        
        if ($result->getDeletedCount() > 0) {
            return response()->json(["¡Se ha eliminado su comentario correctamente!", 1], 200);
        } else {
            return response()->json(["¡ No se encontró la publicación o el comentario no existe!", 0], 200);
        }
    }

    public function editarRespuestaComentarioPost(Request $request){
        $collection = self::$mongoDB->selectCollection('respuesta_comentario_post');

        $comentarioTexto = $request->input('comentarioTexto');
        $idComentario = $request->input('idComentario');
       
        $resultado = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($idComentario)],
            ['$set' => ['comentarioTexto' => $comentarioTexto]]
        );

        if ($resultado->getModifiedCount() > 0) {
            return response()->json(["¡Se ha modificado su respuesta correctamente!", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }
    }


    public function editarComentarioPost(Request $request){
        $collection = self::$mongoDB->selectCollection('publicaciones');

        $comentarioTexto = $request->input('comentarioTexto');
        $idComentario = $request->input('idComentario');
        $idPublicacion = $request->input('idPublicacion');

        $publicacion = $collection->find([
            '_id' => new \MongoDB\BSON\ObjectID($idPublicacion)
        ])->toArray()[0];


        $bandera = false;
        
        $index = 0;
        foreach ($publicacion->comentarios as $key) {
            if((string) $key["_id"] == $idComentario){
                $comentario = $key;
                $comentario->comentarioTexto = $comentarioTexto;
                break;
            }
            $index++;
        }

        $publicacion->comentarios[$index] = $comentario;    

        $resultado = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($idPublicacion)],
            ['$set' => ['comentarios' => $publicacion->comentarios]]
        );

        if ($resultado->getModifiedCount() > 0) {
            return response()->json(["Comentario Modificado correctamente.", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }
    }
}

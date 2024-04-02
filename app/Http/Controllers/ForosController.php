<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Illuminate\Http\Request;
use DB;

use Jenssegers\Mongodb\Facades\MongoDB;

use Illuminate\Support\Facades\Session;

require 'conexion.php';

class ForosController extends Controller
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

    public function foros(Request $request){
        
        
        $collection = self::$mongoDB->selectCollection('foros');

        $idUsuario = Session::get('id');

        $tipo = $request->input('tipo');

        if($tipo == "estudiante"){
            $result = $collection->aggregate([
                [
                    '$match' => [
                        'estudiantes' =>  new \MongoDB\BSON\Regex($idUsuario)
                    ],
                ],
            ])->toArray();
            
            usort($result, function($a, $b) {
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                return $dateTimeB <=> $dateTimeA; 
            });  

            $collection2 = self::$mongoDB->selectCollection('usuarios');
            foreach ($result as $dato){
                $dato->profesor = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($dato->id_profesor),
                ]);
            }
        }else{
            $result = $collection->aggregate([
                [
                    '$match' => [
                        'id_profesor' =>  new \MongoDB\BSON\ObjectID($idUsuario),
                    ],
                ],
            ])->toArray();

            usort($result, function($a, $b) {
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                return $dateTimeB <=> $dateTimeA; 
            });  

            
            $collection2 = self::$mongoDB->selectCollection('usuarios');
            

            foreach ($result as $dato){
                $dato->profesor = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($dato->id_profesor),
                ]);

                $lista_estudiantes = [];

                foreach($dato->estudiantes as $dato2){
                    $lista_estudiantes[] = $collection2->findOne([
                        '_id' => new \MongoDB\BSON\ObjectID($dato2),
                    ]);
                }

                $dato->lista_estudiantes = $lista_estudiantes;

            }
        }

        return $result;
    }

    public function foro(Request $request){

        
        $collection = self::$mongoDB->selectCollection('foros');

        $id = $request->input('id');

        $foro = $collection->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($id),
        ]);

        $collection2 = self::$mongoDB->selectCollection('usuarios');
        $collection3 = self::$mongoDB->selectCollection('respuestas_comentarios');

        $foro->profesor = $collection2->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($foro->id_profesor),
        ]);

        foreach ($foro->comentarios as $comentario){
            $comentario->usuario = $collection2->findOne([
                '_id' => new \MongoDB\BSON\ObjectID($comentario->id_usuario),
            ]);
            
            $respuestas = $collection3->find([
                'id_comentario' => new \MongoDB\BSON\ObjectID($comentario->_id),
            ])->toArray();

            usort($respuestas, function($a, $b) {
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                return $dateTimeB <=> $dateTimeA; 
            });

            foreach($respuestas as $respuesta){
                $respuesta->usuario = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($respuesta->id_usuario),
                ]);
            }

            $comentario->respuestas = $respuestas;
        }

        $comentarios = $foro->comentarios;
        if(count($comentarios) > 0){
            $comentarios = iterator_to_array($foro['comentarios']);
            usort($comentarios, function($a, $b) {
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                return $dateTimeB <=> $dateTimeA; 
            });
        
            $foro['comentarios'] = $comentarios;
        }

        if($foro->ruta != null){
            $parametros = explode('/',$foro->ruta);

            if($parametros[2] == 'N'){
                $foro->contenido_html = self::$mongoDB->selectCollection('cont_documento')->findOne([
                    'id' => (int) $parametros[1],
                ]);
            }else{
                $foro->contenido_html = self::$mongoDB->selectCollection('cont_documento_modulos')->findOne([
                    'id' => (int) $parametros[1],
                ]);
            }
        }
        
        return $foro;
    }

    public function guardarRespuesta(Request $request){
        
        $collection = self::$mongoDB->selectCollection('foros');

        $idUsuario = Session::get('id');
        $idForo = $request->input('id_foro');
        $respuesta = $request->input('respuesta');
       

        $elemento_ingresar = [
            '_id' => new \MongoDB\BSON\ObjectID(),
            'id_usuario' => Session::get('id'),
            'respuesta' => $respuesta,
            'likes' => 0,
            'fecha' => date('d/m/Y'),
            'horas' => date('H:i:s'),
        ];

        $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($idForo)],
            ['$push' => ['comentarios' => $elemento_ingresar]]
        );

        $foro_not = $collection->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($idForo),
        ]);

        self::guardarNotificacion($foro_not->titulo, "foro/".$idForo, 20, $foro_not->id_profesor);

        return response()->json("¡Se ha registrado su respuesta correctamente!", 200);
    
    }

    public function guardarNotificacion($titulo, $ruta, $tipo, $id_profesor){
        $collection2 = self::$mongoDB->selectCollection('notificaciones');
        $timezone = new \DateTimeZone('America/Bogota');
        $fechaActual = new \DateTime('now', $timezone);
        $horaActual = new \DateTime('now', $timezone);
        $idUsuario = (string) Session::get('id');
      
        $noti = [
            'id_profesor' => $id_profesor,
            'id_usuario' => (string) $id_profesor,
            'ruta' => "",
            'tema' => '<strong>'.Session::get('nombre').'</strong> ha publicado una respuesta en el foro '.'<strong>'.$titulo.'</strong>',
            'fecha' => $fechaActual->format('d/m/Y'),
            'horas' => $horaActual->format('H:i:s'),
            'estado' => 'cerrado',
            'tipo' => $tipo,
            'ruta_foro' => $ruta
        ];

        $collection2->insertOne($noti);
    }

    public function guardarRespuestaComentario(Request $request){
        
        $collection = self::$mongoDB->selectCollection('respuestas_comentarios');

        $id_comentario = $request->input('id_comentario');
        $respuesta = $request->input('respuesta');

        $elemento_ingresar = [
            'id_comentario' => new \MongoDB\BSON\ObjectID($id_comentario),
            'id_usuario' => Session::get('id'),
            'respuesta' => $respuesta,
            'fecha' => date('d/m/Y'),
            'horas' => date('H:i:s'),
        ];

        $collection->insertOne($elemento_ingresar);
    }

    public function eliminarRespuesta(Request $request){
        
        $collection = self::$mongoDB->selectCollection('respuestas_comentarios');

        $id_respuesta = $request->input('id');

        $collection->deleteOne(
            [
                '_id' =>new \MongoDB\BSON\ObjectID($id_respuesta),
            ]
        );
    }

    public function editarForo(Request $request){
        
        $collection = self::$mongoDB->selectCollection('foros');
        $collection2 = self::$mongoDB->selectCollection('notificaciones');

        $ids = $request->input('ids');
        $id_foro = $request->input('id_foro');
       
        $foro = $collection->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($id_foro),
        ]);

        $log = "";

        foreach ($ids as $key) {

            $estudiantes = iterator_to_array($foro['estudiantes']);

            $hay = array_filter($estudiantes, function ($value) use ($key)  {
                return $value == $key["id"];
            });

            if(count($hay) != 0){
                $log .= "<p><i class='fas fa-times'></i> El estudiante: ".$key["nombre"]." esta registrado en este foro </p>";
            }else{

                $collection->updateOne(
                    ['_id' => new \MongoDB\BSON\ObjectID($id_foro)],
                    ['$push' => ['estudiantes' => $key["id"]]]
                );

                $collection2 = self::$mongoDB->selectCollection('notificaciones');

                $noti = [
                    'id_profesor' => Session::get('id'),
                    'id_estudiante' => $key["id"],
                    'ruta' => $foro->ruta,
                    'tema' => $foro->titulo,
                    'fecha' => date('d/m/Y'),
                    'horas' => date('H:i:s'),
                    'estado' => 'cerrado',
                    'tipo' => 1,
                    'ruta_foro' => "foro/".$id_foro
                ];
        
                $collection2->insertOne($noti);
                
                $log .= "<p><i class='fas fa-check'></i> El estudiante: ".$key["nombre"]." fue agregado al foro  </p>";
            }
        }

        return response()->json($log, 200);
    }

    public function cambiarEstado(Request $request){
        
        $collection = self::$mongoDB->selectCollection('foros');

        $id = $request->input('id');
        $estado_actual = $request->input('estado_actual');

        $log = "";

        if($estado_actual == "Abierto"){
            $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($id)], 
                [            
                    '$set' => [
                        'estado' => 'Cerrado',
                    ]
                ]
            );

            $log = "Estado cambiado a (<strong> Cerrado </strong>) correctamente";
        }else{
            $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($id)], 
                [            
                    '$set' => [
                        'estado' => 'Abierto',
                    ]
                ]
            );

            $log = "Estado cambiado a (<strong> Abierto </strong>) correctamente";

        }

        return response()->json($log, 200);
    }

    public function comentariosForo(Request $request){

        $collection = self::$mongoDB->selectCollection('foros');
        $id = $request->input('id');

        $foro = $collection->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($id),
        ]);

        $collection2 = self::$mongoDB->selectCollection('usuarios');
        $collection3 = self::$mongoDB->selectCollection('respuestas_comentarios');

        $foro->profesor = $collection2->findOne([
            '_id' => new \MongoDB\BSON\ObjectID($foro->id_profesor),
        ]);

        foreach ($foro->comentarios as $comentario){
            $comentario->usuario = $collection2->findOne([
                '_id' => new \MongoDB\BSON\ObjectID($comentario->id_usuario),
            ]);
            
            $respuestas = $collection3->find([
                'id_comentario' => new \MongoDB\BSON\ObjectID($comentario->_id),
            ])->toArray();

            usort($respuestas, function($a, $b) {
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                return $dateTimeB <=> $dateTimeA; 
            });

            foreach($respuestas as $respuesta){
                $respuesta->usuario = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($respuesta->id_usuario),
                ]);
            }

            $comentario->respuestas = $respuestas;
        }

        $comentarios = $foro->comentarios;
        if(count($comentarios) > 0){
            $comentarios = iterator_to_array($foro['comentarios']);
            usort($comentarios, function($a, $b) {
                $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
                $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
                return $dateTimeB <=> $dateTimeA; 
            });
        }

        return $comentarios;
    }


    public function editarInfoForo(Request $request){
        $collection = self::$mongoDB->selectCollection('foros');

        $info_foro = $request->input('info_foro');
        $id_foro_editar = $request->input('id_foro_editar');

        $result = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id_foro_editar)], 
            [            
                '$set' => $info_foro
            ]
        );

        if ($result->getModifiedCount() > 0) {
            return response()->json(["La información del foro ha sido modificada correctamente", 1], 200);
        } else {
            return response()->json(["Ocurrió un error, intente nuevamente", 1], 200);
        }
    }

    public function eliminarRespuestaForo(Request $request){
        $collection = self::$mongoDB->selectCollection('foros');

        $id_foro = $request->input('id_foro');
        $id_comentario = $request->input('id');

        $result = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id_foro)],
            ['$pull' => ['comentarios' => ['_id' => new \MongoDB\BSON\ObjectID($id_comentario)]]]
        );
        
        if ($result->getModifiedCount() > 0) {
            return response()->json(["¡Se ha eliminado su comentario correctamente!", 1], 200);
        } else {
            return response()->json(["¡ No se encontró la publicación o el comentario no existe!", 0], 200);
        }
    }

    public function editarRespuestaForo(Request $request){

        $collection = self::$mongoDB->selectCollection('foros');

        $comentarioTexto = $request->input('comentarioTexto');
        $id_foro = $request->input('id_foro');
        $id_comentario = $request->input('id');
       
        $publicacion = $collection->find([
            '_id' => new \MongoDB\BSON\ObjectID($id_foro)
        ])->toArray()[0];
        
        

        $index = 0;
        foreach ($publicacion->comentarios as $key) {
            if((string) $key["_id"] == $id_comentario){
                $comentario = $key;
                $comentario->respuesta = $comentarioTexto;
                break;
            }
            $index++;
        }

        $publicacion->comentarios[$index] = $comentario;    

        $resultado = $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id_foro)],
            ['$set' => ['comentarios' => $publicacion->comentarios]]
        );

        if ($resultado->getModifiedCount() > 0) {
            return response()->json(["Comentario Modificado correctamente.", 1], 200);
        }else{
            return response()->json(["¡Ocurrio un error, intente nuevamente!", 0], 200);
        }

    }
}

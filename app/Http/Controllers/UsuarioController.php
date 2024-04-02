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

class UsuarioController extends Controller
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

    public function loginUsuario(Request $request){
       
        $collection = self::$mongoDB->selectCollection('usuarios');

        $correo = $request->input('correo');
        $password = $request->input('password');

        $usuario = $collection->findOne(['correo' => $correo, 'password' => $password]);

        if (!$usuario) {
            return response()->json(["Usuario y/o contraseña incorrecta", 0], 200);
        } else {
            if($usuario->tipo_registro == 'docente'){
                if($usuario->estado == "Activo"){
                    Session::flush();
                    Session::start();
                    Session::put('id', $usuario->_id);
                    Session::put('nombre', $usuario->nombre);
                    Session::put('correo', $usuario->correo);
                    Session::put('imagen', $usuario->imagen);
                    Session::put('tipo_registro', $usuario->tipo_registro);
                    Session::put('logueado', 'ok');
                    
                    return response()->json(["Bienvenido ".$usuario->nombre, 1, $usuario->tipo_registro], 200);
                }else{
                    return response()->json(["Usuario <strong> Inactivo </strong>, comuníquese con el administrador del sitio web.", 0], 200);
                }
            }else{
                if(!property_exists($usuario, 'estado')){
                    Session::flush();
                    Session::start();
                    Session::put('id', $usuario->_id);
                    Session::put('nombre', $usuario->nombre);
                    Session::put('correo', $usuario->correo);
                    Session::put('imagen', $usuario->imagen);
                    Session::put('tipo_registro', $usuario->tipo_registro);
                    Session::put('logueado', 'ok');
                
                    return response()->json(["Bienvenido ".$usuario->nombre, 1, $usuario->tipo_registro], 200);
                }else{
                    if($usuario->estado == "Activo"){
                        Session::flush();
                        Session::start();
                        Session::put('id', $usuario->_id);
                        Session::put('nombre', $usuario->nombre);
                        Session::put('correo', $usuario->correo);
                        Session::put('imagen', $usuario->imagen);
                        Session::put('tipo_registro', $usuario->tipo_registro);
                        Session::put('logueado', 'ok');
                    
                        return response()->json(["Bienvenido ".$usuario->nombre, 1, $usuario->tipo_registro], 200);
                    }else{
                        return response()->json(["Usuario <strong> Inactivo </strong>, comuníquese con el administrador del sitio web.", 0], 200);
                    }
                }
            }
        }
    }

    public function registroUsuarioEstudiante(Request $request){
       
        $collection = self::$mongoDB->selectCollection('usuarios');

        $nombre = $request->input('nombre');
        $sexo = $request->input('sexo');
        $grado = $request->input('grado');
        $grupo = $request->input('grupo');
        $jornada = $request->input('jornada');
        $tipo_registro = $request->input('tipo_registro');
        $correo = $request->input('correo');
        $password = $request->input('password');
        $imagen = $request->input('imagen');

        $usuario = $collection->findOne(['correo' => $correo]);


        if (!$usuario) {

            $usuario = [
                'nombre' => $nombre,
                'sexo' => $sexo,
                'grado' => $grado,
                'grupo' => $grupo,
                'jornada' => $jornada,
                'tipo_registro' => $tipo_registro,
                'imagen' => $imagen,
                'correo' => $correo,
                'password' => $password,
            ];

            $result = $collection->insertOne($usuario);

            $userId = $result->getInsertedId();

            Session::flush();
            Session::start();
            Session::put('id',$userId);
            Session::put('nombre', $nombre);
            Session::put('correo', $correo);
            Session::put('imagen', $imagen);
            Session::put('tipo_registro', $tipo_registro);
            Session::put('logueado', 'ok');

            return response()->json(["Usuario registrado corectamente.", 1, "estudiante"], 200);
        } else {
            return response()->json(["Ya hay un usuario registrado con ese nombre de correo.", 0], 200);
        }
    }

    public function cerrarSesion(){
        Session::flush();
        return 1;
    }

    public function misDatos(){
        $collection = self::$mongoDB->selectCollection('usuarios');

        $idUsuario = Session::get('id');

        $usuario = $collection->findOne(
            [
                '_id' => new \MongoDB\BSON\ObjectID($idUsuario)
            ]
        );
        
        return response()->json($usuario, 200);
        
    }

    public function editarEstudiante(Request $request){
        $collection = self::$mongoDB->selectCollection('usuarios');

        $idUsuario = Session::get('id');

        $nombre = $request->input('nombre');
        $sexo = $request->input('sexo');
        $grado = $request->input('grado');
        $grupo = $request->input('grupo');
        $jornada = $request->input('jornada');
        $tipo_registro = $request->input('tipo_registro');
        $correo = $request->input('correo');
        $password = $request->input('password');
        $imagen = $request->input('imagen');

        $usuario = $collection->findOne(
            [
                'correo' => $correo,
                '_id' => ['$ne' => new \MongoDB\BSON\ObjectID($idUsuario)],
            ]
        );


        if (!$usuario) {

            $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($idUsuario)], 
                [            
                    '$set' => [
                        'nombre' => $nombre,
                        'sexo' => $sexo,
                        'grado' => $grado,
                        'grupo' => $grupo,
                        'jornada' => $jornada,
                        'tipo_registro' => $tipo_registro,
                        'imagen' => $imagen,
                        'correo' => $correo,
                        'password' => $password,
                    ]
                ]
            );

            Session::flush();
            Session::start();
            Session::put('id',$idUsuario);
            Session::put('nombre', $nombre);
            Session::put('correo', $correo);
            Session::put('imagen', $imagen);
            Session::put('tipo_registro', $tipo_registro);
            Session::put('logueado', 'ok');

            return response()->json(["Usuario editado corectamente.", 1], 200);
        } else {
            return response()->json(["Ya hay un usuario registrado con ese nombre de correo.", 0], 200);
        }
    }

    public function cambiarPassword(Request $request){
        $collection = self::$mongoDB->selectCollection('usuarios');

        $idUsuario = Session::get('id');
        $password_old = $request->input('password_old');
        $password_new = $request->input('password_new');

        $usuario = $collection->findOne(
            [
                'password' => $password_old,
                '_id' => new \MongoDB\BSON\ObjectID($idUsuario),
            ]
        );

        if ($usuario) {
            $collection->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($idUsuario)], 
                [            
                    '$set' => [
                        'password' => $password_new,
                    ]
                ]
            );
            return response()->json(["¡Contraseña actualizada correctamente!", 1], 200);
        }else{
            return response()->json(["¡La contraseña anterior no es correcta!", 0], 200);
        }

    }

    public function sessionData(){
        $data = [
            "id" => Session::get('id'),
            "nombre" => Session::get('nombre'),
            "correo" => Session::get('correo'),
            "imagen" => Session::get('imagen'),
            "tipo_registro" => Session::get('tipo_registro')

        ];

        return response()->json($data , 200);
    }

    public function estudiantesCompartir(Request $request){
        $collection = self::$mongoDB->selectCollection('usuarios');
        $grado = $request->input('grado');
        $grupo = $request->input('grupo');
        $jornada = $request->input('jornada');

        $usuarios = $collection->find(
            [
                'grado' => $grado,
                'grupo' => $grupo,
                'jornada' => $jornada,
            ]
        )->toArray();

        return response()->json($usuarios, 200);
    }

    public function compartirContenido(Request $request){
        $collection = self::$mongoDB->selectCollection('recomendaciones');

        $idUsuario = Session::get('id');
        $ids = $request->input('ids');
        $titulo = $request->input('titulo');
        $ruta = $request->input('ruta');

        $usuario = [
            'estudiantes' => $ids,
            'id_profesor' => Session::get('id'),
            'titulo' => $titulo,
            'ruta' => $ruta,
            'fecha' => date('d/m/Y'),
            'horas' => date('H:i:s')
        ];

        $collection->insertOne($usuario);

        $collection2 = self::$mongoDB->selectCollection('notificaciones');


        foreach ($ids as $key) {
            $noti = [
                'id_profesor' => Session::get('id'),
                'id_estudiante' => $key,
                'ruta' => $ruta,
                'tema' => $titulo,
                'fecha' => date('d/m/Y'),
                'horas' => date('H:i:s'),
                'estado' => 'cerrado',
                'tipo' => 0
            ];
    
            $collection2->insertOne($noti);
        }

        return response()->json("¡Se compartio correctamente el contenido, con los estudiantes seleccionados!", 200);
    }

    public function recomendacionesDocente(Request $request){
        $collection = self::$mongoDB->selectCollection('recomendaciones');

        $idUsuario = Session::get('id');
        $texto = $request->input('texto');

        if($texto == "todo"){
            $datos_agrupados = $collection->aggregate([
                [
                    '$match' => [
                        'id_profesor' => new \MongoDB\BSON\ObjectID($idUsuario),
                    ],
                ],
            ]);

            $datos_agrupados = $datos_agrupados->toArray();

            $collection2 = self::$mongoDB->selectCollection('usuarios');
            foreach ($datos_agrupados as $dato){
                $dato->alumnos_recomendados = [];
                foreach($dato->estudiantes as $dato2){
                    $dato->alumnos_recomendados[] = $collection2->findOne([
                        '_id' => new \MongoDB\BSON\ObjectID($dato2),
                    ]);
                }
            }
        }else{
            $datos_agrupados = $collection->aggregate([
                [
                    '$match' => [
                        'id_profesor' => new \MongoDB\BSON\ObjectID($idUsuario),
                        'titulo' => ['$regex' => $texto, '$options' => 'i']
                    ],
                ],
            ]);

            $datos_agrupados = $datos_agrupados->toArray();

            $collection2 = self::$mongoDB->selectCollection('usuarios');
            foreach ($datos_agrupados as $dato){
                $dato->alumnos_recomendados = [];
                foreach($dato->estudiantes as $dato2){
                    $dato->alumnos_recomendados[] = $collection2->findOne([
                        '_id' => new \MongoDB\BSON\ObjectID($dato2),
                    ]);
                }
            }
        }

        usort($datos_agrupados, function($a, $b) {
            $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
            $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
            return $dateTimeB <=> $dateTimeA; 
        });  

        return response()->json($datos_agrupados, 200);
    }

    public function recomendacionesEstudiante(Request $request){
        $collection = self::$mongoDB->selectCollection('recomendaciones');

        $idUsuario = Session::get('id');
        $texto = $request->input('texto');

        if($texto == "todo"){
            $datos_agrupados = $collection->aggregate([
                [
                    '$match' => [
                        'estudiantes' =>  new \MongoDB\BSON\Regex($idUsuario)
                    ],
                ],
            ]);

            $datos_agrupados = $datos_agrupados->toArray();

            $collection2 = self::$mongoDB->selectCollection('usuarios');
            foreach ($datos_agrupados as $dato){
                $dato->profesor = $collection2->findOne([
                    '_id' => new \MongoDB\BSON\ObjectID($dato->id_profesor),
                ]);

            }
        }else{
            $datos_agrupados = $collection->aggregate([
                [
                    '$match' => [
                        'estudiantes' => [
                            '$elemMatch' => ['_id' => new \MongoDB\BSON\ObjectID($idUsuario)],
                        ],
                        'titulo' => ['$regex' => $texto, '$options' => 'i']
                    ],
                ],
            ]);

            $datos_agrupados = $datos_agrupados->toArray();
        }

        usort($datos_agrupados, function($a, $b) {
            $dateTimeA = \DateTime::createFromFormat('d/m/Y H:i:s', $a['fecha'] . ' ' . $a['horas'], new \DateTimeZone('America/Bogota'));
            $dateTimeB = \DateTime::createFromFormat('d/m/Y H:i:s', $b['fecha'] . ' ' . $b['horas'], new \DateTimeZone('America/Bogota'));
            return $dateTimeB <=> $dateTimeA; 
        });  
        
        return response()->json($datos_agrupados, 200);
    }

    public function notificaciones(){
        if(Session::has('logueado')){
            $idUsuario = Session::get('id');
            
            $collection = self::$mongoDB->selectCollection('notificaciones');
            $collectionUsuarios = self::$mongoDB->selectCollection('usuarios');
    
            $ide = (string) $idUsuario;
    
            $resultados = $collection->aggregate([
                ['$match' => [
                    '$or' => [
                        ['id_estudiante' => $ide],
                        ['id_usuario' => $ide],
                    ],
                ]],
                [
                    '$sort' => [
                        '_id' => -1,
                    ],
                ],
                ['$limit' => 10]
            ])->toArray();

            foreach ($resultados as $item) {
               if($item->tipo == 1  || $item->tipo == 0){
                    $item->profesor = $collectionUsuarios->findOne(
                        ['_id' =>  $item->id_profesor]      
                    );
               }
            }
    
            return response()->json($resultados, 200);
        }else{
            return response()->json([], 200);
        }
    }

    public function cambiarestadoNotificacion(Request $request){
        $collection = self::$mongoDB->selectCollection('notificaciones');

        $id = $request->input('id');

        $collection->updateOne(
            ['_id' => new \MongoDB\BSON\ObjectID($id)], 
            [            
                '$set' => [
                    'estado' => 'abierto',
                ]
            ]
        );

        return response()->json(1, 200);
    }

    public function verificarLogin(){
        if(Session::has('logueado')){
            return response()->json(1, 200);
        }else{
            return response()->json(0, 200);
        }
    }

    public function crearForo(Request $request){
        $collection = self::$mongoDB->selectCollection('foros');

        $idUsuario = Session::get('id');
        $ids = $request->input('ids');
        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $ruta = $request->input('ruta');
        $id_contenido = $request->input('id_contenido');
        $tipo_contenido = $request->input('tipo_contenido');

        $foro = [
            'id_profesor' => Session::get('id'),
            'id_contenido' => $id_contenido,
            'tipo_contenido' => $tipo_contenido,
            'estudiantes' => $ids,
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'ruta' => $ruta,
            'fecha' => date('d/m/Y'),
            'horas' => date('H:i:s'),
            'comentarios'=> [],
            'estado' => 'Abierto'
        ];

        $result = $collection->insertOne($foro);
        $documentoInsertadoId = $result->getInsertedId();

        $collection2 = self::$mongoDB->selectCollection('notificaciones');


        foreach ($ids as $key) {
            $noti = [
                'id_profesor' => Session::get('id'),
                'id_estudiante' => $key,
                'ruta' => $ruta,
                'tema' => $titulo,
                'fecha' => date('d/m/Y'),
                'horas' => date('H:i:s'),
                'estado' => 'cerrado',
                'tipo' => 1,
                'ruta_foro' => "foro/".$documentoInsertadoId
            ];
    
            $collection2->insertOne($noti);
        }

        return response()->json("¡Se ha creado el foro correctamente!", 200);
    }

    public function guardarSeleccion(Request $request){
        $collection = self::$mongoDB->selectCollection('apuntes');

        $id_usuario = Session::get('id');
        $id_contenido = $request->input('id_contenido');
        $titulo = $request->input('titulo');
        $tipo_contenido = $request->input('tipo_contenido');
        $data = $request->input('data');
        $ruta = $request->input('ruta');

        if($id_usuario != null){
            $apuntes = $collection->find(
                [
                    'id_usuario' => $id_usuario,
                ]
            )->toArray();
    
            if(count($apuntes) <= 10){
                $filtro = [
                    'id_contenido' => $id_contenido,
                    'tipo_contenido' => $tipo_contenido,
                ];
                
                $actualizacion = [
                    '$set' => [
                        'titulo' => $titulo,
                        'id_usuario' => $id_usuario,
                        'data' => $data,
                        'ruta' => $ruta,
                        'fecha' => date('d/m/Y'),
                        'horas' => date('H:i:s'),
                    ],
                    '$setOnInsert' => $filtro, 
                ];
                
                $opciones = [
                    'upsert' => true,
                ];
                
                $resultado = $collection->updateOne($filtro, $actualizacion, $opciones);
                return response()->json(['mensaje' => '¡Tus apuntes se han guardado correctamente!', 'estado' => 1]);
            }else{
                return response()->json(['mensaje' => '¡La cantidad maxima de apuntes que puedes guardar es (10)!', 'estado' => 0]);
            }
        }else{
            return response()->json(['mensaje' => '¡Debe iniciar sesión para poder guardar sus apuntes!', 'estado' => 0]);
        }
        
    }

    public function listarApuntes(Request $request){
        $variable1 = $request->input('id');
        $variable2 = $request->input('tipo');

        $collection = self::$mongoDB->selectCollection('apuntes');

        $idUsuario = Session::get('id');
            
        $respuesta = $collection->find(
            [
                'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
            ]
        )->toArray();

        
        return response()->json($respuesta, 200);
        
    } 

    public function eliminarApunte(Request $request){
        $collection = self::$mongoDB->selectCollection('apuntes');

        $id_apunte = $request->input('id');

        $collection->deleteOne(
            [
                '_id' =>new \MongoDB\BSON\ObjectID($id_apunte),
            ]
        );
    }
}

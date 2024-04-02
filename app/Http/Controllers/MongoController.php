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

use HTMLPurifier;
use HTMLPurifier_Config;

use Illuminate\Support\Str;

require 'conexion.php';

class MongoController extends Controller
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

    public function busquedaMongo(Request $request){
        $variable1 = $request->input('textoBusqueda');
        $variable2 = $request->input('tipoBusqueda');
        $pagina = $request->input('pagina');

        $asignatura = $request->input('asignatura');
        $grado = $request->input('grado');

        $limit = 10;

        if ($pagina == null || $pagina == "") {
            $pagina = 1;
        }

        if ($pagina == 1) {
            $offset = 0;
            $pagina--;
        } else {
            $pagina--;
            $offset = $pagina * $limit;
        }

        
        $collection = self::$mongoDB->selectCollection('contenido_busqueda');

       
        $resultados = [];
        $resultados1 = [];
        $resultados2 = [];
        $array_id = [];
       
        self::guardarBusqueda($request);

        if($variable2 == "contenido"){

            $match = ['$match' => [
                'titulo' => ['$regex' => $variable1, '$options' => 'i']
            ]];
            
            if ($asignatura != 'no' || $grado != 'no') {
                $match['$match']['$and'] = [];
            
                if ($asignatura != 'no') {
                    $match['$match']['$and'][] = ['asignatura' => $asignatura];
                }
            
                if ($grado != 'no') {
                    $match['$match']['$and'][] = ['grado' => $grado];
                }
            }
            
            $resultados1 = $collection->aggregate([
                $match,
                ['$project' => [
                    '_id' => 0,
                    'contenido_busqueda' => '$$ROOT',
                ]],
            ])->toArray();


            foreach ($resultados1 as $res) {
                array_push($array_id, $res->contenido_busqueda->id);
            }
           

            $match2 = ['$match' => [
                'contenido_texto' => ['$regex' => " ".$variable1." ", '$options' => 'i'],
                'contenido_busqueda.id' => ['$nin' => $array_id]
            ]];

            if ($asignatura != 'no' || $grado != 'no') {
                $match2['$match']['$and'] = [];
            
                if ($asignatura != 'no') {
                    $match2['$match']['$and'][] = ['asignatura' => $asignatura];
                }
            
                if ($grado != 'no') {
                    $match2['$match']['$and'][] = ['grado' => $grado];
                }
            }

            $resultados2 =  $collection->aggregate([
                $match2,
                ['$project' => [
                    '_id' => 0,
                    'contenido_busqueda' => '$$ROOT',
                ]],
            ])->toArray();


            $resultados = array_merge($resultados1, $resultados2);

            if(count($resultados) >= 3){
                
                $resultados = array_slice($resultados, $offset, 10); 

                $palabra = $variable1;
    
                foreach ($resultados as $resultado) {
                    $parrafos = preg_split('/\n\s*\n/', $resultado->contenido_busqueda->contenido_texto);
    
                    $parrafoEncontrado = null;
                    foreach ($parrafos as $parrafo) {
                        if (strpos($parrafo, $palabra) !== false) {
                            $parrafoEncontrado = $parrafo;
                            $resultado->parrafo = $parrafoEncontrado;
                            break;
                        }else{
                            $resultado->parrafo = $resultado->contenido_busqueda->contenido_texto;
                        }
                    }
                }
            }else{
                $palabrasArray = explode(' ', $variable1);

                $palabrasFiltradas = array_filter($palabrasArray, function($palabra) {
                    return mb_strlen($palabra) >= 3;
                });

                $match = ['$match' => [
                    'modulo' => ['$ne' => null],
                ]];
    
                if ($asignatura != 'no' || $grado != 'no') {
                    $and = [];

                    if ($asignatura != 'no') {
                        $and[] = ['asignatura' => $asignatura];
                    }

                    if ($grado != 'no') {
                        $and[] = ['grado' => $grado];
                    }

                    $match['$match']['$and'] = $and;
                }

                $resultados_n = $collection->aggregate([
                    $match,
                    ['$project' => [
                        '_id' => 0,
                        'contenido_busqueda' => '$$ROOT',
                    ]],
                ])->toArray();
               

               foreach ($resultados_n as $resultado) {
                    $cont = 0;
                    foreach ($palabrasFiltradas as $palabra){
                        $patron = "/\b" . preg_quote($palabra, '/') . "\b/i";
                        if($encontrado = preg_match($patron, $resultado->contenido_busqueda->contenido_texto)){
                            $cont++;
                        }
                    }

                    if($cont > (count($palabrasFiltradas) / 2)){
                        $resultado->palabras_encontradas = $cont;
                        array_push($resultados,  $resultado);
                    }
                }

                $resultados = collect($resultados)->sortByDesc('palabras_encontradas')->all();
                
                $resultados = array_slice($resultados, $offset, 10);
               

                foreach ($resultados as $resultado) {
                    $parrafos = preg_split('/\n\s*\n/', $resultado->contenido_busqueda->contenido_texto);
                    if(count($parrafos) == 1){
                        $resultado->parrafo = $parrafos[0];
                    }else{
                        $resultado->parrafo = $parrafos[1];
                    }
                    
                }
            }

            return response()->json($resultados);
        }else{
            if($variable2 == "imagenes"){
                $resultados = $collection->aggregate([
                    ['$match' => [
                        '$or' => [
                            ['tema' => ['$regex' => $variable1, '$options' => 'i']],
                            ['titulo' => ['$regex' => $variable1, '$options' => 'i']],
                        ]
                    ]],
                    ['$project' => [
                        '_id' => 0,
                        'datos' => '$$ROOT',
                    ]],
                    [
                        '$skip' => (5 * $pagina),
                    ],
                    ['$limit' => 5 * ($pagina + 1)]
                ])->toArray();

                foreach($resultados as $item){
                    if($item->datos->tipo_contenido =="N"){
                        $item->datos->cont_documento = self::$mongoDB->selectCollection('cont_documento')->findOne(['id' => $item->datos->id_contenido])->cont_documento;
                    }else{
                        $item->datos->cont_documento = self::$mongoDB->selectCollection('cont_documento_modulos')->findOne(['id' => $item->datos->id_contenido])->cont_documento;
                    }
                }
                
       
                return response()->json($resultados, 200);
            }else{
                if($variable2 == "videos"){
                    $resultados = self::buscarVideos($variable1, $variable2, $request->input('pagina'), $grado, $asignatura);
                    return response()->json($resultados, 200);
                }else{
                    $collection2 = self::$mongoDB->selectCollection('multimedia');
                    $resultados = $collection2->aggregate([
                        ['$match' => 
                        [
                            '$and' => [
                                ['tipo_multimedia' => 'metafacto']
                            ],
                            '$or' => [
                                ['tema' => ['$regex' => $variable1, '$options' => 'i']],
                                ['tema_sin_tilde' => ['$regex' => $variable1, '$options' => 'i']],
                            ]
                        ]],
                        ['$project' => [
                            '_id' => 0,
                            'datos' => '$$ROOT',
                        ]],
                        ['$skip' => (10 * $pagina)],
                        ['$limit' => 10 * ($pagina + 1)]
                    ])->toArray();

                    return response()->json($resultados, 200);
                }
            }
        }
    }

    public function buscarVideos($variable1, $variable2, $pagina, $grado, $asignatura){
       
        $collection = self::$mongoDB->selectCollection('multimedia');

        $limit = 10;

        if ($pagina == null || $pagina == "") {
            $pagina = 1;
        }

        if ($pagina == 1) {
            $offset = 0;
            $pagina--;
        } else {
            $pagina--;
            $offset = $pagina * $limit;
        }
        
        $match = ['$match' => [
            '$and' => [
                ['tipo_multimedia' => 'video']
            ],
            '$or' => [
                ['tema' => ['$regex' => $variable1, '$options' => 'i']],
                ['tema_sin_tilde' => ['$regex' => $variable1, '$options' => 'i']],
            ]
        ]];
        
        if ($asignatura != 'no') {
            $match['$match']['$and'][] = ['asignatura' => $asignatura];
        }
    
        if ($grado != 'no') {
            $match['$match']['$and'][] = ['grado' => $grado];
        }
       
        $resultados = $collection->aggregate([
            $match,
            ['$project' => [
                '_id' => 0,
                'contenido_busqueda' => '$$ROOT',
            ]],
            [
                '$skip' => $offset,
            ],
            [
                '$limit' => $limit,
            ]
        ])->toArray();

        foreach ($resultados as $key) {
            if ($key->contenido_busqueda->tipo_contenido == "asignatura") {
                
                $collection2 = self::$mongoDB->selectCollection('cont_documento');

                $contenido_doc = $collection2->findOne(
                    [
                        'contenido' => intval($key->contenido_busqueda->id_contenido),
                    ]
                );

                $key->contenido_busqueda->id_original = $contenido_doc->id;
                $key->contenido_busqueda->parrafo = self::obtenerPrimerParrafoLargo2($contenido_doc->cont_documento);
            }else{
                
                $collection2 = self::$mongoDB->selectCollection('cont_documento_modulos');

                $contenido_doc = $collection2->findOne(
                    [
                        'contenido' => intval($key->contenido_busqueda->id_contenido),
                    ]
                );

                $key->contenido_busqueda->id_original = $contenido_doc->id;
                $key->contenido_busqueda->parrafo = self::obtenerPrimerParrafoLargo2($contenido_doc->cont_documento);
            }
        }

        return $resultados;
    }

    public function obtenerPrimerParrafoLargo2($html) {
        $dom = new \DOMDocument();
    
        $dom->loadHTML($html);
    
        $parrafos = $dom->getElementsByTagName('p');
    
        foreach ($parrafos as $parrafo) {
            $contenido = $parrafo->textContent;

            if (strpos($contenido, 'data:image') !== false) {
                continue; 
            }

            $palabras = str_word_count($contenido);

            if ($palabras > 10) {
                return $contenido;
            }
        }
    
        return "No se encontró ningún párrafo largo.";
    }

    public function guardarBusqueda(Request $request){
        $variable1 = $request->input('textoBusqueda');
        $variable2 = $request->input('tipoBusqueda');
        $pagina = $request->input('pagina');

        $collection = self::$mongoDB->selectCollection('busquedas');
        $collection_globales = self::$mongoDB->selectCollection('busquedas_globales');

        date_default_timezone_set('America/Bogota');

        // Configurar el idioma de Carbon a español
        Carbon::setLocale('es');

        // Obtener la fecha, el día de la semana y la hora actual en Colombia usando Carbon
        $fecha_actual = Carbon::now()->format('Y-m-d');
        $dia_de_la_semana_actual = Carbon::now()->isoFormat('dddd, D [de] MMMM [del] Y');
        $hora_actual = Carbon::now()->format('H:i:s');

        if($pagina == 1){
            if (Session::has('id')) {

                if($variable2 == "contenido"){
                    $ruta = "resultado-busqueda/".$variable1."/contenido/1";
                }else{
                    if($variable2 == "imagenes"){
                        $ruta = "resultado-imagenes/".$variable1."/imagenes";
                    }else{
                        if($variable2 == "videos"){
                            $ruta = "resultado-videos/".$variable1."/videos/1";
                        }else{
                            $ruta = "resultado-metafactos/".$variable1."/metafactos/1";
                        }
                    }
                }

                $busqueda = [
                    'id_usuario' => Session::get('id'),
                    'texto_busqueda' => $variable1,
                    'ruta' => $ruta,
                    'dia' => $dia_de_la_semana_actual,
                    'fecha' => $fecha_actual,
                    'hora' => $hora_actual
                ];
    
                $collection->insertOne($busqueda);
            }
        }

        $busqueda_global = [
            'texto_busqueda' => $variable1,
            'dia' => $dia_de_la_semana_actual,
            'fecha' => $fecha_actual,
            'hora' => $hora_actual
        ];

        $collection_globales->insertOne($busqueda_global);
    }


    public function paginacion(Request $request){

        $variable1 = $request->input('textoBusqueda');
        $variable2 = $request->input('tipoBusqueda');
        $pagina = $request->input('pagina');

        $asignatura = $request->input('asignatura');
        $grado = $request->input('grado');

        $collection = self::$mongoDB->selectCollection('contenido_busqueda');

        $array_id = [];

        $match = ['$match' => [
            'titulo' => ['$regex' => $variable1, '$options' => 'i']
        ]];
        
        if ($asignatura != 'no' || $grado != 'no') {
            $match['$match']['$and'] = [];
        
            if ($asignatura != 'no') {
                $match['$match']['$and'][] = ['asignatura' => $asignatura];
            }
        
            if ($grado != 'no') {
                $match['$match']['$and'][] = ['grado' => $grado];
            }
        }

        $resultados1 = $collection->aggregate([
            $match,
            ['$project' => [
                '_id' => 0,
                'contenido_busqueda' => '$$ROOT',
            ]],
        ])->toArray();

        foreach ($resultados1 as $res) {
            array_push($array_id, $res->contenido_busqueda->id);
        }
       
        $match2 = ['$match' => [
            'contenido_texto' => ['$regex' => " ".$variable1." ", '$options' => 'i'],
            'contenido_busqueda.id' => ['$nin' => $array_id]
        ]];

        if ($asignatura != 'no' || $grado != 'no') {
            $match2['$match']['$and'] = [];
        
            if ($asignatura != 'no') {
                $match2['$match']['$and'][] = ['asignatura' => $asignatura];
            }
        
            if ($grado != 'no') {
                $match2['$match']['$and'][] = ['grado' => $grado];
            }
        }

        $resultados2 =  $collection->aggregate([
            $match2,
            ['$project' => [
                '_id' => 0,
                'contenido_busqueda' => '$$ROOT',
            ]],
        ])->toArray();
        
        $numero_filas = count(array_merge($resultados1, $resultados2));

        if($numero_filas < 3){

            $palabrasArray = explode(' ', $variable1);

            $palabrasFiltradas = array_filter($palabrasArray, function($palabra) {
                return mb_strlen($palabra) >= 3;
            });

            $numero_filas = 0;

            $match = ['$match' => [
                'modulo' => ['$ne' => null],
            ]];

            if ($asignatura != 'no' || $grado != 'no') {
                $and = [];

                if ($asignatura != 'no') {
                    $and[] = ['asignatura' => $asignatura];
                }

                if ($grado != 'no') {
                    $and[] = ['grado' => $grado];
                }

                $match['$match']['$and'] = $and;
            }

            $resultados_n = $collection->aggregate([
                $match,
                ['$project' => [
                    '_id' => 0,
                    'contenido_busqueda' => '$$ROOT',
                ]],
            ])->toArray();

           foreach ($resultados_n as $resultado) {
                $cont = 0;
                foreach ($palabrasFiltradas as $palabra){
                    $patron = "/\b" . preg_quote($palabra, '/') . "\b/i";
                    if($encontrado = preg_match($patron, $resultado->contenido_busqueda->contenido_texto)){
                        $cont++;
                    }
                }

                if($cont > (count($palabrasFiltradas) / 2)){
                   $numero_filas += 1;
                }
            }

        }

        $paginas = ceil($numero_filas / 10);
        
        $respuesta = [
            'paginas_consulta' => $paginas,
            'pagina_actual' => (int)$pagina,
            'numero_registros' => $numero_filas,
        ];
        
        return response()->json($respuesta, 200);
    }

    public function busquedaContenido(Request $request){

        $variable1 = $request->input('id');
        $variable2 = $request->input('tipo');

        $resultados = [];

        if ($variable2 == "N") {
            $collection = self::$mongoDB->selectCollection('cont_documento');
            $resultados = $collection->find(['id' => intval($variable1)]);
        }else{
            $collection = self::$mongoDB->selectCollection('cont_documento_modulos');
            $resultados = $collection->find(['id' => intval($variable1)]);
        }

        $respuesta = [
            'datos' => $resultados->toArray(),
        ];

        return response()->json($respuesta, 200);

    }

    public function historial(Request $request){
        
        $collection = self::$mongoDB->selectCollection('busquedas');

        $idUsuario = Session::get('id');

        $texto = $request->input('texto');

        if($texto == "todo"){
           $datos_agrupados = $collection->aggregate([
                [
                    '$match' => [
                        'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
                    ],
                ],
                [
                    '$group' => [
                        '_id' => '$dia',
                        'fecha' => ['$first' => '$fecha'],
                        'cantidad' => ['$sum' => 1],
                    ],
                ],
                [
                    '$sort' => [
                        'fecha' => -1,
                    ],
                ],
            ]);

            $datos_agrupados = $datos_agrupados->toArray();

            foreach ($datos_agrupados as $dato){
                $dato->busquedas_dia = $collection->aggregate([
                    [
                        '$match' => [
                            'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
                            'dia' => $dato->_id,
                        ],
                    ],
                    [
                        '$sort' => [
                            'hora' => -1,
                        ],
                    ],
                ])->toArray();
            }
        }else{
            $datos_agrupados = $collection->aggregate([
                [
                    '$match' => [
                        'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
                        'texto_busqueda' => ['$regex' => $texto, '$options' => 'i']
                    ],
                ],
                [
                    '$group' => [
                        '_id' => '$dia',
                        'fecha' => ['$first' => '$fecha'],
                        'cantidad' => ['$sum' => 1],
                    ],
                ],
                [
                    '$sort' => [
                        'fecha' => -1,
                    ],
                ],
            ]);

            $datos_agrupados = $datos_agrupados->toArray();

            foreach ($datos_agrupados as $dato){
                $dato->busquedas_dia = $collection->aggregate([
                    [
                        '$match' => [
                            'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
                            'dia' => $dato->_id,
                            'texto_busqueda' => ['$regex' => $texto, '$options' => 'i']
                        ],
                    ],
                    [
                        '$sort' => [
                            'hora' => -1,
                        ],
                    ],
                ])->toArray();
            }
        }

        
        

        return response()->json($datos_agrupados, 200);

    }

    public function eliminar_historial(Request $request){
        
        $collection = self::$mongoDB->selectCollection('busquedas');

        $idUsuario = Session::get('id');

        $tipo = $request->input('tipo');

    
        if($tipo == "1"){
            $fechaActual = date('Y-m-d');
            $condiciones = [
                'id_usuario' => $idUsuario,
                'fecha' => $fechaActual,
            ];
        }else{
            if($tipo == "2"){
                $fechaHace7Dias = date('Y-m-d', strtotime('-7 days'));

                $condiciones = [
                    'id_usuario' => $idUsuario,
                    'fecha' => ['$gte' => $fechaHace7Dias], 
                ];
            }else{
                $condiciones = [
                    'id_usuario' => $idUsuario,
                ];
            }
        }

        $result = $collection->deleteMany($condiciones);

        return response()->json($result->getDeletedCount(), 200);

    }

    public function busquedaApunte(Request $request){

        $variable1 = $request->input('id');
        $variable2 = $request->input('tipo');

        $collection = self::$mongoDB->selectCollection('apuntes');

        $idUsuario = Session::get('id');
            
        $respuesta = $collection->findOne(
            [
                'id_usuario' => new \MongoDB\BSON\ObjectID($idUsuario),
                'id_contenido' => intval($variable1),
                'tipo_contenido' => $variable2
            ]
        );

        if ($respuesta) {
            return response()->json($respuesta, 200);
        } else {
            return response()->json(['data' => null], 200);
        }
        
    } 

    public function paginacion_multimedia(Request $request){

        $variable1 = $request->input('textoBusqueda');
        $variable2 = $request->input('tipoBusqueda');
        $pagina = $request->input('pagina');
        $asignatura = $request->input('asignatura');
        $grado = $request->input('grado');

        $collection = self::$mongoDB->selectCollection('multimedia');

       
        $match = ['$match' => [
            '$and' => [
                ['tipo_multimedia' => 'video']
            ],
            '$or' => [
                ['tema' => ['$regex' => $variable1, '$options' => 'i']],
                ['tema_sin_tilde' => ['$regex' => $variable1, '$options' => 'i']],
            ]
        ]];
        
           
        if ($asignatura != 'no') {
            $match['$match']['$and'][] = ['asignatura' => $asignatura];
        }
    
        if ($grado != 'no') {
            $match['$match']['$and'][] = ['grado' => $grado];
        }
       

        $resultados = $collection->aggregate([
            $match,
            ['$project' => [
                '_id' => 0,
                'contenido_busqueda' => '$$ROOT',
            ]],
        ])->toArray();

        
        $numero_filas = count($resultados);


        $paginas = ceil($numero_filas / 10);
        
        $respuesta = [
            'paginas_consulta' => $paginas,
            'pagina_actual' => (int)$pagina,
            'numero_registros' => $numero_filas,
        ];
        
        return response()->json($respuesta, 200);
    }

    function removeAccents($str) {
        $unwanted = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
        );
    
        return strtr($str, $unwanted);
    }

    
    public function borrarBusquedasSeleccionadas(Request $request){
        $collection = self::$mongoDB->selectCollection('busquedas');
        
        $ids_eliminar = $request->input("ids_eliminar");

        $ids_eliminar = array_map(function ($id) {
            return new \MongoDB\BSON\ObjectID($id);
        }, $ids_eliminar);
        
        $condiciones = [
            '_id' => ['$in' => $ids_eliminar]
        ];
          
        $result = $collection->deleteMany($condiciones);

        return response()->json($result->getDeletedCount(), 200);
    }

    public function listarMentefactos(Request $request){
        $collection = self::$mongoDB->selectCollection('multimedia');
        $asignatura = $request->input("asignatura");


        $condiciones = [
            'asignatura' => $asignatura,
            'tipo_multimedia' => 'metafacto'
        ];
          
        $result = $collection->find($condiciones)->toArray();

        return response()->json($result, 200);

    }
}

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

use Smalot\PdfParser\Parser;

use Goutte\Client as GoutteClient;


require 'conexion.php';

class DiccionarioController extends Controller{

    protected static $mongoClient;
    protected static $mongoDB;

    public function __construct() {
        $instanciaConexion = new ClaseConexion();

        if (!isset(self::$mongoClient)) {
            self::$mongoClient = $instanciaConexion::$mongoClient;
        }

        if (!isset(self::$mongoDB)) {
            self::$mongoDB = $instanciaConexion::$mongoDB;
        }
    }

    public function palabras_tilde(Request $request) {
        $collection = self::$mongoDB->selectCollection('palabras');
      
        $resultado = $collection->find([
            'palabra' => ['$regex' => '[áéíóúÁÉÍÓÚ]']
        ])->toArray();

        $collection2 = self::$mongoDB->selectCollection('palabras_tilde');

        $palabras_agregadas = 0;
        foreach ($resultado as $line) {
            $line = $line->palabra;
            $line = mb_strtolower($line, 'UTF-8');
            if (preg_match('/[áéíóú]/u', $line)) {
                $wordCount = $collection2->count(['palabra' => $line]);
                if ($wordCount == 0) {
                    $elemento_ingresar = [
                        'palabra' => $line,
                        'sin_tilde' =>  self::removeAccents($line),
                    ];
                    $collection2->insertOne($elemento_ingresar);
                    $palabras_agregadas++;
                }
            }
        }
        return 'se agregaron: '.$palabras_agregadas;
    }

    function removeAccents($str) {
        $unwanted = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'Á' => 'A',
            'É' => 'E',
            'Í' => 'I',
            'Ó' => 'O',
            'Ú' => 'U',
        );
    
        return strtr($str, $unwanted);
    }

    public function leerDiccionario(Request $request) {
        $collection = self::$mongoDB->selectCollection('diccionario');

        $rutaPdf = public_path('diccionario-1.txt');
        $contenido = file_get_contents($rutaPdf);
        $parrafos = explode("->", $contenido);

        $palabras_agregadas = 0;

        foreach ($parrafos as $parrafo) {
            $tamanio = explode('.', $parrafo);
            if(count($tamanio) >= 2){
                $parrafo_limpio = str_replace("\n", " ", $parrafo);
                $palabra = explode('.', $parrafo_limpio, 2);

                $elemento_ingresar = [
                    'palabra' => $palabra[0],
                    'significado' => $palabra[1],
                ];
    
                $collection->insertOne($elemento_ingresar);
                $palabras_agregadas++;
            }
        }
       
        return 'se agregaron: '.$palabras_agregadas;
    }

    public function limpiar_palabras(Request $request) {
        $collection_diccionario = self::$mongoDB->selectCollection('diccionario');
      

        $expresionRegular = new \MongoDB\BSON\Regex(" o ");
        $valoresUnicos = $collection_diccionario->find(
            ['palabra' => $expresionRegular],
        )->toArray();


        $caracteresEspeciales = array(',');
        foreach ($valoresUnicos as &$documento) {
            //$documento->palabra = str_replace($caracteresEspeciales, '', $documento->palabra);
            $palabra_corregida = explode(" o ", $documento->palabra)[0];
            $collection_diccionario->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($documento->_id)], 
                [            
                    '$set' => [
                        'palabra' => $palabra_corregida,
                    ]
                ]
            );
        }
    }

    public function insertarPalabras(){
        $collection_diccionario = self::$mongoDB->selectCollection('diccionario');
        $collection = self::$mongoDB->selectCollection('palabras');

        $palabras = "";

        $palabras = json_decode($palabras, true);

        foreach ($palabras as $key) {  
            $elemento_ingresar = [
                'palabra' =>  mb_strtolower($key["es_name"], 'UTF-8')
            ];
            $collection->insertOne($elemento_ingresar);
        }
    }

    public function palabraAproximada(Request $request) {
        $palabras = $request->input("cadena");

        $palabras = self::verificarTildes2($palabras);

        $palabras = explode(' ', $palabras);

        $collection = self::$mongoDB->selectCollection('palabras');
        $cache = [];

        $string_resultante = [];
        $bandera = false;

        foreach ($palabras as $palabra) {
            if(strlen($palabra) > 2){
                $palabra = mb_strtolower($palabra, 'UTF-8');
                // Comprobar si ya hemos buscado esta palabra antes
                if (isset($cache[$palabra])) {
                    $palabraMasSimilar = $cache[$palabra];
                } else {
                    $palabra_existente = $collection->find(
                        ['palabra' => $palabra],
                    )->toArray();

                    if(count($palabra_existente) > 0){
                        $palabraMasSimilar = $palabra_existente[0]->palabra;
                    }else{
                        $resultado = $collection->find();
    
                        $palabraMasSimilar = "";
                        $distanciaEdicionMinima = PHP_INT_MAX;
        
                        foreach ($resultado as $documento) {
                            $palabraEnColeccion = $documento->palabra;
                            $distanciaEdicion = levenshtein($palabra, $palabraEnColeccion);
                            if ($distanciaEdicion < $distanciaEdicionMinima) {
                                $distanciaEdicionMinima = $distanciaEdicion;
                                $palabraMasSimilar = $palabraEnColeccion;
                            }
                        }
        
                        $cache[$palabra] = $palabraMasSimilar;
                        $bandera = true;
                    }                    
                }
    
                if ($palabraMasSimilar !== "") {
                    $string_resultante[] = $palabraMasSimilar;
                } else {
                    $string_resultante[] = $palabra;
                }
            }else{
                $string_resultante[] = $palabra;
            }
        }

        if (count($cache) > 100) {
            $cache = [];
        }


        $concatenado = implode(' ', $string_resultante);

        return response()->json(
            [
                "original" => $request->input("cadena"), 
                "cadena" => $concatenado, 
                "corregido" => $bandera,
            ], 
            200
        );
    }

    public function verificarTildes2($cadena) {
        $collection = self::$mongoDB->selectCollection('palabras_tilde');
        $palabras = explode(' ', $cadena);

        $string_resultante = [];
        $bandera = false;
        
        foreach ($palabras as $key) {
            $condiciones = [
                'sin_tilde' => [
                    '$regex' => '^' . preg_quote($key) . '$',
                    '$options' => 'i' 
                ]
            ];

            $palabra = $collection->findOne($condiciones);
            
            if ($palabra) {
                $string_resultante[] = $palabra->palabra;
                $bandera = true;
            } else {
                $string_resultante[] = $key;
            }
        }

        $concatenado = implode(' ', $string_resultante);

        return $concatenado;
    }

    public function buscarPalabraDiccionario(Request $request){
        $palabra_r = $request->input("palabra");

        $singularWord = Str::singular($palabra_r);

        $palabra_similar = self::palabraAproximadaDiccionario($singularWord);

        $collection_diccionario = self::$mongoDB->selectCollection('diccionario');

        $palabra_encontrada = $collection_diccionario->findOne([
            'palabra' => [
                '$regex' => '^' . preg_quote($palabra_r) . '$',
                '$options' => 'i' 
            ]
        ]);

        $bandera = false;
        $bandera2 = false;
        $mensaje_opcional = "";

        if($palabra_encontrada == null){
            $bandera2 = true;
            $palabra_r = $palabra_similar[0];
            $palabra_encontrada = $collection_diccionario->findOne([
                'palabra' => [
                    '$regex' => '^' . preg_quote($palabra_r) . '$',
                    '$options' => 'i' 
                ]
            ]);
            if($palabra_encontrada != null){
                $bandera = true;
                $mensaje_opcional = "Se muestran resultados de <strong>(".$palabra_r.")</strong><br>";
                $significado = $palabra_encontrada->significado;
            }else{
                $significado = "No se encontraron resultados para la palabra <strong>(".$palabra_r.")</strong>";
            }
        }else{
            $bandera = true;
            $significado = $palabra_encontrada->significado;
        }


        if($palabra_encontrada != null){
            return [
                "mensaje_opcional" => $mensaje_opcional,
                "significado" => $significado,
                "bandera" => $bandera,
                "imagenes" => $palabra_encontrada->imagenes,
                "imagenes" => [],
                "sugerencias" => $bandera2 == true ?  $palabra_similar[1] : []
            ];
        }else{
            return [
                "mensaje_opcional" => $mensaje_opcional,
                "significado" => $significado,
                "bandera" => $bandera,
                "imagenes" => [],
                "sugerencias" => $bandera2 == true ?  $palabra_similar[1] : []
            ];
        }
        
    }

    public function palabraAproximadaDiccionario($palabras) {

        $palabras = self::verificarTildes2($palabras);

        $palabras = explode(' ', $palabras);

        $collection = self::$mongoDB->selectCollection('palabras');
        $cache = [];

        $string_resultante = [];
        $stings = [];

        foreach ($palabras as $palabra) {
            // Comprobar si ya hemos buscado esta palabra antes
            if (isset($cache[$palabra])) {
                $palabraMasSimilar = $cache[$palabra];
            } else {
                
                $resultado = $collection->find();

                $palabraMasSimilar = "";
                $distanciaEdicionMinima = PHP_INT_MAX;

                foreach ($resultado as $documento) {
                    $palabraEnColeccion = $documento->palabra;
                    $distanciaEdicion = levenshtein($palabra, $palabraEnColeccion);

                    if ($distanciaEdicion < $distanciaEdicionMinima) {
                        $distanciaEdicionMinima = $distanciaEdicion;
                        $palabraMasSimilar = $palabraEnColeccion;
                    }

                    if($distanciaEdicion < 2){
                        $stings[] = $palabraEnColeccion;
                    }
                }

                $cache[$palabra] = $palabraMasSimilar;
            }

            if ($palabraMasSimilar !== "") {
                $string_resultante[] = $palabraMasSimilar;
            } else {
                $string_resultante[] = $palabra;
            }
        }

        if (count($cache) > 100) {
            $cache = [];
        }


        $concatenado = implode(' ', $string_resultante);
        
        $bandera = true;
       
        return [$concatenado, $stings];
    }

    
    public function insertarImagenes(){

        $collection_diccionario = self::$mongoDB->selectCollection('diccionario');

        $palabra_encontrada = $collection_diccionario->find(
            [],
            [
                'skip' => 83708,
                'limit' => 150000,
            ]
        )->toArray();

        foreach ($palabra_encontrada as $documento) {
            $query = $documento->palabra;

            $client = new GoutteClient();
    
            $crawler = $client->request('GET', 'https://www.google.com/search?q=' . $query . '&tbm=isch&tbs=isz:ex,iszw:400,iszh:400');
    
            $htmlContent = $crawler->html();
          
            $dom = new \DOMDocument();
            $dom->loadHTML($htmlContent);
    
            $imageElements = $dom->getElementsByTagName('img');

            $element = $imageElements[2];
            $element2 = $imageElements[3];
           
            
            if ($element) {
                $imageUrl =  $element->getAttribute('src');
                $imageData = base64_encode(file_get_contents($imageUrl));
            }else{
                $imageData = "";
            }

            if ($element2) {
                $imageUrl2 =  $element2->getAttribute('src');
                $imageData2 = base64_encode(file_get_contents($imageUrl2));
            }else{
                $imageData2 = "";
            }


            $images = [
                ['url' => $imageData],
                ['url' => $imageData2],
            ];

            $collection_diccionario->updateOne(
                ['_id' => new \MongoDB\BSON\ObjectID($documento->_id)],
                ['$set' => ['imagenes' => $images]]
            );
        }
    }

    /*
    public function insertarImagenes(){

        $palabra_encontrada = DB::connection('mysql')->table('productos')->get();

        foreach ($palabra_encontrada as $documento) {

            $query = $documento->descripcion;

            $client = new GoutteClient();
    
            $crawler = $client->request('GET', 'https://www.google.com/search?q=' . $query . '&tbm=isch&tbs=isz:ex,iszw:400,iszh:400');
    
            $htmlContent = $crawler->html();
          
            $dom = new \DOMDocument();
            $dom->loadHTML($htmlContent);
    
            $imageElements = $dom->getElementsByTagName('img');

            $element = $imageElements[2];
           
            if ($element) {
                $imageUrl =  $element->getAttribute('src');
                $imageData = base64_encode(file_get_contents($imageUrl));
            }else{
                $imageData = "";
            }

            DB::connection('mysql')->table('productos')
            ->where('id', $documento->id)
            ->update([
                'imagen' => $imageData,
            ]);

        }
    }
    */
}
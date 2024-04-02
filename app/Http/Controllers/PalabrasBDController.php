<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


require 'conexion.php';

class PalabrasBDController extends Controller
{
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

    function limpiarBD(){
        $collection = self::$mongoDB->selectCollection('palabras');

        $documentosAEliminar = $collection->find([
            'palabra' => [
                '$regex' => new \MongoDB\BSON\Regex('http', 'i')
            ]
        ])->toArray();

        $collection->deleteMany([
            'palabra' => [
                '$regex' => new \MongoDB\BSON\Regex('http', 'i')
            ]
        ]);
        
        // Puedes imprimir el número de documentos eliminados si lo deseas
        $numDocumentosEliminados = count($documentosAEliminar);
        return "Se eliminaron $numDocumentosEliminados documentos.";
    }

    function procesarArchivoTxt(){
        
        $rutaArchivo = public_path('libro.txt');
        
        if (!file_exists($rutaArchivo)) {
            return ['error' => 'El archivo no existe'];
        }

        $contenido = file_get_contents($rutaArchivo);

        $contenido = mb_strtolower($contenido, 'UTF-8');
        $contenido = preg_replace('/[0-9\p{P}(){}\[\]=?%|&#-@−]/u', '', $contenido);

        $palabras = preg_split('/\s+/', $contenido);

        $palabrasFiltradas = array_filter($palabras, function($palabra) {
            return mb_strlen($palabra, 'UTF-8') > 4;
        });
    
        $palabrasFiltradas = array_unique($palabrasFiltradas);

        $resultado = array_combine(range(1, count($palabrasFiltradas)), $palabrasFiltradas);
        //return response()->json($resultado)->header('Content-Type', 'application/json; charset=utf-8');
        return self::insertar_palabras($resultado);
        
    }

    public function insertar_palabras($json_datos) {
        $collection = self::$mongoDB->selectCollection('palabras');

        $palabras_agregadas = 0;
        $palabras_agg = [];

        foreach ($json_datos as $key) {
            $existente = $collection->find(['palabra' => $key])->toArray();
            if (count($existente) == 0) {
                $collection->insertOne(['palabra' => $key]);
                $palabras_agregadas += 1;
                $palabras_agg[] = $key;
            }
        }

        return ["mensajes" => 'se agregaron: '.$palabras_agregadas, "palabras_agg" => $palabras_agg];
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
}

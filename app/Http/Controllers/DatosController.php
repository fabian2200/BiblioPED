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

require 'conexion.php';

class DatosController extends Controller
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

    public function crearContenidoBusqueda(){

        $collection = self::$mongoDB->selectCollection('contenido_busqueda');

        /*
        $datos = DB::connection('mysql')->table('cont_documento') 
        ->join('contenido', 'contenido.id', 'cont_documento.contenido')
        ->join('modulos', 'modulos.id', 'contenido.modulo')
        ->join('asignaturas', 'asignaturas.id', 'modulos.asignatura')
        ->select(
        "cont_documento.*", 
        "contenido.modulo", 
        "cont_documento.titulo", 
        "modulos.grado_modulo", 
        "asignaturas.nombre as asignatura"
        )->get();
        */
        
        $datos = DB::connection('mysql')->table('cont_documento_modulos') 
        ->join('contenido_modulo', 'contenido_modulo.id', 'cont_documento_modulos.contenido')
        ->join('grados_modulos', 'grados_modulos.id', 'contenido_modulo.modulo')
        ->join('modulos_transversales', 'modulos_transversales.id', 'grados_modulos.modulo')
        ->select(
        "cont_documento_modulos.*", 
        "contenido_modulo.modulo", 
        "cont_documento_modulos.titulo", 
        "grados_modulos.grado_modulo", 
        "modulos_transversales.nombre as asignatura"
        )->get();
        

        $cont = 2016;
        foreach ($datos as $dato) {
            $contenido_texto = self::convertirHtmlATexto($dato->cont_documento);
            $imagen = self::obtenerPrimeraImagen($dato->cont_documento);

            $datoInport = [
                'id' => intval($cont),
                'id_contenido' => $dato->id,
                'tipo_contenido' => 'T',
                'contenido_texto' => $contenido_texto,
                'contenido_texto_sin_tilde' => self::removeAccents($contenido_texto),
                'imagen' => $imagen,
                'modulo' => intval($dato->modulo),
                'titulo' => $dato->titulo,
                'titulo_sin_tilde' => self::removeAccents($dato->titulo),
                'grado' => $dato->grado_modulo,
                'asignatura' => $dato->asignatura
            ];

            $datoData = json_decode(json_encode($datoInport), true);
            $collection->insertOne($datoData);
            $cont++;
        }

    }

    public function convertirHtmlATexto($html){
       
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.Allowed', '');
        $purifier = new HTMLPurifier($config);
        
        $texto = $purifier->purify($html);
        
        return $texto;
    }

    function obtenerPrimeraImagen($html){
        if(strlen($html) > 0){
            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML($html);

            $imagenes = $dom->getElementsByTagName('img');

            if ($imagenes->length > 0) {
                $primeraImagen = $imagenes->item(0);
                $src = $primeraImagen->getAttribute('src');
                return $src;
            }else{
                return "";
            }
        }else{ 
            return "";
        }
    }

    public function migrartablasCont()
    {
        $resultados = DB::table('cont_documento_modulos')
        ->select('cont_documento_modulos.*')
        ->get();
        
        foreach ($resultados as $resultado) {
          
            $dato = [
                'id' => $resultado->id,
                'contenido' => $resultado->contenido,
                'titulo' => $resultado->titulo,
                'cont_documento' => $resultado->cont_documento,
                'created_at' => $resultado->created_at,
                'updated_at' => $resultado->updated_at,
            ];

            $collection = self::$mongoDB->selectCollection('cont_documento_modulos');

            $collection->insertOne($dato);
        }


        $resultados2 = DB::table('cont_documento')
        ->select('cont_documento.*')
        ->get();
        
        foreach ($resultados2 as $resultado) {
          
            $dato2 = [
                'id' => $resultado->id,
                'contenido' => $resultado->contenido,
                'titulo' => $resultado->titulo,
                'cont_documento' => $resultado->cont_documento,
                'created_at' => $resultado->created_at,
                'updated_at' => $resultado->updated_at,
            ];

            $collection2 = self::$mongoDB->selectCollection('cont_documento');

            $collection2->insertOne($dato2);
        }


        return response()->json("las tablas han sido copiadas... <3", 200);
    }

    public function migrarVideos()
    {
        $collection->deleteMany([
            'tipo_multimedia' => "video"
        ]);

        /*
        $resultados = DB::connection('mysql')
        ->table('cont_didactico as cd')
        ->select('cd.contenido', 'cd.titulo', 'cd.cont_didactico', 'c.titu_contenido', 'a.nombre', 'm.grado_modulo')
        ->join('contenido as c', 'cd.contenido', '=', 'c.id')
        ->join('modulos as m', 'c.modulo', '=', 'm.id')
        ->join('asignaturas as a', 'm.asignatura', '=', 'a.id')
        ->get();
        */
        
        $resultados = DB::table('cont_didactico_modulos as cd')
        ->select('cd.contenido', 'cd.titulo', 'cd.cont_didactico', 'c.titu_contenido', 'a.nombre', 'm.grado_modulo')
        ->join('contenido_modulo as c', 'cd.contenido', '=', 'c.id')
        ->join('grados_modulos as m', 'c.modulo', '=', 'm.id')
        ->join('modulos_transversales as a', 'm.modulo', '=', 'a.id')
        ->get();
        

        foreach ($resultados as $resultado) {
          
            $dato = [
                'tipo_multimedia' => 'video',
                'tipo_contenido' => 'modulo transversal',
                'id_contenido' => $resultado->contenido,
                'asignatura' => $resultado->nombre,
                'grado' => $resultado->grado_modulo,
                'tema' => $resultado->titu_contenido,
                'tema_sin_tilde' => self::removeAccents($resultado->titu_contenido),
                'ruta' => $resultado->cont_didactico,
                'fecha' => date('d/m/Y'),
                'horas' => date('H:i:s'),
            ];

            $collection = self::$mongoDB->selectCollection('multimedia');

            $collection->insertOne($dato);
        }

        return response()->json("guardado", 200);
    }

    public function migrarMetafactos()
    {
        $collection = self::$mongoDB->selectCollection('multimedia');
              
        $collection->deleteMany([
            'tipo_multimedia' => "metafacto"
        ]);

        $resultados = DB::table('imagenes_moduloe as ime')
        ->select('ime.id', 'ime.imagen', 'tme.titulo', 'ame.nombre', 'ame.grado')
        ->join('temas_moduloe as tme', 'tme.id', '=', 'ime.tema')
        ->join('asignaturas_mode as ame', 'ame.id', '=', 'tme.asignatura')
        ->where('ime.imagen', '!=', '')
        ->get();


        foreach ($resultados as $resultado) {
            $dato = [
                'tipo_multimedia' => 'metafacto',
                'asignatura' => $resultado->nombre,
                'grado' => $resultado->grado,
                'tema' => $resultado->titulo,
                'tema_sin_tilde' => self::removeAccents($resultado->titulo),
                'ruta' => $resultado->imagen,
                'fecha' => date('d/m/Y'),
                'horas' => date('H:i:s'),
            ];

            $collection->insertOne($dato);
        }

        return response()->json("guardado", 200);
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

<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Illuminate\Http\Request;
use DB;

use Jenssegers\Mongodb\Facades\MongoDB;

use Illuminate\Support\Facades\Session;
use PDF;
use Illuminate\Http\Response;

require 'conexion.php';

class ExportarController extends Controller
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

    public function generateApuntesPDF(Request $request){

        $collection = self::$mongoDB->selectCollection('apuntes');

        $id = $request->input('id');
        $idUsuario = Session::get('id');

        $apunte = $collection->findOne(
            [
                '_id' => new \MongoDB\BSON\ObjectID($id),
            ]
        );

        $data = [
            'titulo' => $request->input('titulo'),
            'html' => $apunte->data
        ];
        
        $pdf = PDF::loadView('pdf.apuntes', $data);
    
        $fileName = 'apunte_usuario' . $idUsuario . '.pdf';

        $filePath = public_path('pdfgenerados/'.$fileName);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        $pdf->save($filePath);

        return response()->json($fileName, 200);
    } 
}

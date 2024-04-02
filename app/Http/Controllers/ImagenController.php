<?php

namespace App\Http\Controllers;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use DB;
use Illuminate\Database\Eloquent\Model;
use HTMLPurifier;
use HTMLPurifier_Config;
use DOMDocument;

use Jenssegers\Mongodb\Connection;
use MongoDB\Client;
use Jenssegers\Mongodb\Facades\MongoDB;
use Carbon\Carbon;

class ImagenController extends Controller
{
    public function ConvertirImagen(Request $request)
    {
        /*
        $resultados = DB::connection('mysql')->table('cont_documento')
        ->select("cont_documento.*")
        ->get();

        foreach ($resultados as $resultado) {
            $valor_nuevo = self::reducirImagenesBase64($resultado->cont_documento);
            DB::connection('mysql')->table('cont_documento')
            ->where('cont_documento.id', '=', $resultado->id)
            ->update(['cont_documento' => $valor_nuevo]);
        }
        */
        

        $resultados = DB::connection('mysql')->table('cont_documento_modulos')
        ->select("cont_documento_modulos.*")
        ->get();

        foreach ($resultados as $resultado) {
            $valor_nuevo = self::reducirImagenesBase64($resultado->cont_documento);
            DB::connection('mysql')->table('cont_documento_modulos')
            ->where('cont_documento_modulos.id', '=', $resultado->id)
            ->update(['cont_documento' => $valor_nuevo]);
        }
        

        return response()->json("guardado_ok", 200);
    }

    function reducirImagenesBase64($html) {
        if(strlen($html) > 0){

            $dom = new \DOMDocument();
            libxml_use_internal_errors(true);
            $dom->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">'. $html);

            $images = $dom->getElementsByTagName('img');
            if(count($images) > 0){
                foreach ($images as $image) {
                    $data = $image->getAttribute('src');
                    $base64 = explode(',', $data);
    
                    if(count($base64) > 1){
                    $encodedImage = $base64[1];
                        $decodedImage = base64_decode($encodedImage);
                        $resizedImage = Image::make($decodedImage)->resize(630, null, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
    
                        $newBase64 = 'data:image/' . $resizedImage->mime . ';base64,' . base64_encode($resizedImage->encode());
    
                        $image->setAttribute('src', $newBase64);  
                    }
                
                }

                $cleanHTML = $dom->saveHTML();

                return $cleanHTML;
            }else{
                return $html;
            }
        }else {
            return $html;
        }
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\MongoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FavoritosController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ForosController;
use App\Http\Controllers\DatosController;
use App\Http\Controllers\ExportarController;
use App\Http\Controllers\ComunidadController;
use App\Http\Controllers\DiccionarioController;
use App\Http\Controllers\PalabrasBDController;


use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes/web.php
// Rutas de la API
Route::prefix('api')->group(function () {
    Route::get('/check-connection', function () {
        if (checkInternetConnection()) {
            return true;
        } else {
            return false;
        }
    });
    
    Route::get('/busqueda', [MongoController::class, 'busquedaMongo'])->name('busqueda');
    Route::get('/paginacion', [MongoController::class, 'Paginacion'])->name('paginacion');
    Route::get('/busqueda-contenido', [MongoController::class, 'busquedaContenido'])->name('busquedaContenido');
    Route::get('/historial', [MongoController::class, 'historial'])->name('historial');
    Route::get('/eliminar-historial', [MongoController::class, 'eliminar_historial'])->name('eliminar_historial');
    Route::get('/busqueda-apunte', [MongoController::class, 'busquedaApunte'])->name('busquedaApunte');
    Route::post('/borrar-busquedas-seleccionadas', [MongoController::class, 'borrarBusquedasSeleccionadas'])->name('borrarBusquedasSeleccionadas');
    Route::get('/paginacion-multimedia', [MongoController::class, 'paginacion_multimedia'])->name('paginacion_multimedia');

   
    Route::post('/login', [UsuarioController::class, 'loginUsuario'])->name('login');
    Route::post('/registrar', [UsuarioController::class, 'registroUsuarioEstudiante'])->name('registrar');
    Route::get('/cerrar-sesion', [UsuarioController::class, 'cerrarSesion'])->name('cerrarSesion');
    Route::get('/mis-datos', [UsuarioController::class, 'misDatos'])->name('misDatos');
    Route::post('/editar-usuario-estudiante', [UsuarioController::class, 'editarEstudiante'])->name('editarEstudiante');
    Route::post('/cambiar-password', [UsuarioController::class, 'cambiarPassword'])->name('cambiarPassword');
    Route::get('/session-data', [UsuarioController::class, 'sessionData'])->name('sessionData');
    Route::get('/estudiantes-compartir', [UsuarioController::class, 'estudiantesCompartir'])->name('estudiantesCompartir');
    Route::post('/compartir-contenido', [UsuarioController::class, 'compartirContenido'])->name('compartirContenido');
    Route::get('/recomendaciones-docente', [UsuarioController::class, 'recomendacionesDocente'])->name('recomendacionesDocente');
    Route::get('/recomendaciones-estudiante', [UsuarioController::class, 'recomendacionesEstudiante'])->name('recomendacionesEstudiante');
    Route::get('/notificaciones', [UsuarioController::class, 'notificaciones'])->name('notificaciones');
    Route::get('/cambiarestadoNotificacion', [UsuarioController::class, 'cambiarestadoNotificacion'])->name('cambiarestadoNotificacion');
    Route::get('/verificarLogin', [UsuarioController::class, 'verificarLogin'])->name('verificarLogin');
    Route::post('/crear-foro', [UsuarioController::class, 'crearForo'])->name('crearForo');
    Route::post('/guardar-seleccion', [UsuarioController::class, 'guardarSeleccion'])->name('guardarSeleccion');
    Route::get('/listarApuntes', [UsuarioController::class, 'listarApuntes'])->name('listarApuntes');
    Route::get('/eliminar-apunte', [UsuarioController::class, 'eliminarApunte'])->name('eliminarApunte');


    Route::post('/agregar-favorito', [FavoritosController::class, 'agregarFavorito'])->name('agregarFavorito');
    Route::get('/verificar-favorito', [FavoritosController::class, 'BuscarFavorito'])->name('BuscarFavorito');
    Route::get('/eliminar-favorito', [FavoritosController::class, 'EliminarFavorito'])->name('EliminarFavorito');
    Route::get('/mis-favoritos', [FavoritosController::class, 'MisFavoritos'])->name('MisFavoritos');
    Route::post('/eliminar-favoritos', [FavoritosController::class, 'eliminarFavoritos'])->name('eliminarFavoritos');


    //para cargar el contenido en mongo
    Route::get('/bajar-peso', [ImagenController::class, 'ConvertirImagen'])->name('convertirImagen');
    Route::get('/copiar', [DatosController::class, 'migrartablasCont'])->name('migrartablasCont');
    Route::get('/crear-tabla-contenido', [DatosController::class, 'crearContenidoBusqueda'])->name('crear_tabla_contenido');
    Route::get('/migrar-videos', [DatosController::class, 'migrarVideos'])->name('migrarVideos');
    Route::get('/migrar-metafactos', [DatosController::class, 'migrarMetafactos'])->name('migrarMetafactos');

    
    Route::post('/registro-docente', [AdminController::class, 'RegistroDocente'])->name('RegistroDocente');
    Route::get('/listar-docentes', [AdminController::class, 'listarDocentes'])->name('listarDocentes');
    Route::post('/editar-docente', [AdminController::class, 'editarDocente'])->name('editarDocente');
    Route::get('/listar-estudiantes', [AdminController::class, 'listarEstudiantes'])->name('listarEstudiantes');
    Route::post('/registro-estudiante', [AdminController::class, 'registroEstudiante'])->name('registroEstudiante');
    Route::post('/editar-estudiante', [AdminController::class, 'editarEstudiante'])->name('editarEstudiante');
    Route::get('/datosDashboard', [AdminController::class, 'datosDashboard'])->name('datosDashboard');
    Route::get('/estadisticaData', [AdminController::class, 'estadisticaData'])->name('estadisticaData');
    Route::get('/info-colegio', [AdminController::class, 'infoColegio'])->name('infoColegio');
    Route::post('/editar-info-colegio', [AdminController::class, 'editarInfoColegio'])->name('editarInfoColegio');


    Route::get('/foros', [ForosController::class, 'foros'])->name('foros');
    Route::get('/foro', [ForosController::class, 'foro'])->name('foro');
    Route::post('/guardar-respuesta', [ForosController::class, 'guardarRespuesta'])->name('guardarRespuesta');
    Route::post('/guardar-respuesta-comentario', [ForosController::class, 'guardarRespuestaComentario'])->name('guardarRespuestaComentario');
    Route::get('/eliminar-respuesta', [ForosController::class, 'eliminarRespuesta'])->name('eliminarRespuesta');
    Route::post('/editar-foro', [ForosController::class, 'editarForo'])->name('editarForo');
    Route::get('/cambiar-estado', [ForosController::class, 'cambiarEstado'])->name('cambiarEstado');
    Route::get('/comentarios-foro', [ForosController::class, 'comentariosForo'])->name('ComentariosForo');
    Route::post('/editar-info-foro', [ForosController::class, 'editarInfoForo'])->name('editarInfoForo');
    Route::get('/eliminar-respuesta-foro', [ForosController::class, 'eliminarRespuestaForo'])->name('eliminarRespuestaForo');
    Route::post('/editar-respuesta-foro', [ForosController::class, 'editarRespuestaForo'])->name('editarRespuestaForo');

    Route::post('/corregir-texto', [AdminController::class, 'corregirTexto'])->name('corregirTexto');
    Route::post('/guardar-contenido', [AdminController::class, 'guardarContenido'])->name('guardarContenido');
    Route::get('/listar-contenido-registrado', [AdminController::class, 'consultarContenidoRegistrado'])->name('consultarContenidoRegistrado');
    Route::post('/editar-contenido', [AdminController::class, 'editarContenido'])->name('editarContenido');
    Route::post('/eliminar-contenido', [AdminController::class, 'eliminarContenido'])->name('eliminarContenido');

    Route::post('/pdf-apuntes', [ExportarController::class, 'generateApuntesPDF'])->name('generateApuntesPDF');
    
    Route::post('/guardar-publicacion', [ComunidadController::class, 'guardarPublicacion'])->name('guardarPublicacion');
    Route::get('/listar-publicaciones', [ComunidadController::class, 'listarPublicaciones'])->name('listarPublicaciones');
    Route::post('/guardar-comentario-post', [ComunidadController::class, 'registrarComentarioPost'])->name('registrarComentarioPost');
    Route::get('/eliminar-comentario-post', [ComunidadController::class, 'eliminarComentarioPost'])->name('eliminarComentarioPost');
    Route::get('/listar-usuarios-comunidad', [ComunidadController::class, 'listarUsuariosComunidad'])->name('listarUsuariosComunidad');
    Route::post('/editar-publicacion', [ComunidadController::class, 'editarPublicacion'])->name('editarPublicacion');
    Route::get('/eliminar-post', [ComunidadController::class, 'eliminarPost'])->name('eliminarPost');
    Route::post('/me-gusta', [ComunidadController::class, 'meGusta'])->name('meGusta');
    Route::get('/info-post', [ComunidadController::class, 'infoPost'])->name('infoPost');
    Route::get('/numero-posts', [ComunidadController::class, 'numeroPost'])->name('numeroPost');
    Route::post('/me-gusta-comentario', [ComunidadController::class, 'meGustaComentario'])->name('meGustaComentario');
    Route::post('/guardar-respuesta-comentario-post', [ComunidadController::class, 'guardarRespuestaComentarioPost'])->name('guardarRespuestaComentarioPost');
    Route::get('/eliminar-respuesta-comentario', [ComunidadController::class, 'eliminarRespuestaComentario'])->name('eliminarRespuestaComentario');
    Route::post('/editar-respuesta-comentario-post', [ComunidadController::class, 'editarRespuestaComentarioPost'])->name('editarRespuestaComentarioPost');
    Route::post('/editar-comentario-post', [ComunidadController::class, 'editarComentarioPost'])->name('editarComentarioPost');
    
    Route::get('/diccionario', [DiccionarioController::class, 'leerDiccionario'])->name('palabras_tilde');
    Route::get('/corregir-cadena', [DiccionarioController::class, 'palabraAproximada'])->name('verificarTildes');
    Route::get('/limpiar-palabras', [DiccionarioController::class, 'limpiar_palabras'])->name('palabraAproximada');
    Route::get('/agregar-tildes', [DiccionarioController::class, 'palabras_tilde'])->name('palabraAproximada');
    Route::get('/buscar-palabra-diccionario', [DiccionarioController::class, 'buscarPalabraDiccionario'])->name('buscarPalabraDiccionario');
    Route::get('/insertar-palabras', [DiccionarioController::class, 'insertarPalabras'])->name('insertarPalabras');
    Route::get('/insertar-imagenes', [DiccionarioController::class, 'insertarImagenes'])->name('insertarImagenes');

    Route::get('/insertar-palabras-bd', [PalabrasBDController::class, 'procesarArchivoTxt'])->name('procesarArchivoTxt');
    Route::get('/limpiar-bd', [PalabrasBDController::class, 'limpiarBD'])->name('limpiarBD');
    Route::get('/insertar-palabras-tilde-bd', [PalabrasBDController::class, 'palabras_tilde'])->name('palabras_tilde');
    
    Route::get('/listar-mentafactos', [MongoController::class, 'listarMentefactos'])->name('listarMentefactos');
});

Route::get('/{any}', function () {
    return view('vue');
})->where('any', '.*');


function checkInternetConnection()
{
    try {
        $response = \Illuminate\Support\Facades\Http::get('https://www.google.com');

        return $response->successful();
    } catch (Exception $e) {
        return false;
    }
}
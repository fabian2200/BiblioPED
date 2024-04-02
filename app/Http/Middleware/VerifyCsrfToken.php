<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        '/api/registrar',
        '/api/agregar-favorito',
        '/api/editar-usuario-estudiante',
        '/api/cambiar-password',
        '/api/registro-docente',
        '/api/compartir-contenido',
        '/api/crear-foro',
        '/api/guardar-respuesta',
        '/api/guardar-respuesta-comentario',
        '/api/editar-foro',
        '/api/corregir-texto',
        '/api/guardar-seleccion',
        '/api/pdf-apuntes',
        '/api/guardar-contenido',
        '/api/editar-contenido',
        '/api/eliminar-contenido',
        '/api/guardar-publicacion',
        '/api/editar-publicacion',
        '/api/me-gusta',
        '/api/registro-estudiante',
        '/api/editar-estudiante',
        '/api/login'
    ];
}

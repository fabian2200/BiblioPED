import {http} from "./http_services";

export function guardarPublicacion($data) {
    return http().post(
        '/api/guardar-publicacion', 
        $data, 
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
    );
}

export function listarPublicaciones(pagina_comentarios) {
    return http().get('/api/listar-publicaciones?pagina='+pagina_comentarios);
}

export function registrarComentarioPost($data) {
    return http().post(
        '/api/guardar-comentario-post', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function eliminarRespuestaComentario(id_publicacion, id_comentario) {
    return http().get('/api/eliminar-comentario-post?id_publicacion='+id_publicacion+'&id_comentario='+id_comentario);
}

export function listarUsuariosComunidad() {
    return http().get('/api/listar-usuarios-comunidad');
}

export function editarPublicacion($data) {
    return http().post(
        '/api/editar-publicacion', 
        $data, 
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
    );
}

export function EliminarPost(id_publicacion) {
    return http().get('/api/eliminar-post?id_publicacion='+id_publicacion);
}

export function meGustaPost($data) {
    return http().post(
        '/api/me-gusta', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function infoPost(id_publicacion) {
    return http().get('/api/info-post?id='+id_publicacion);
}

export function listarPublicacionPorID(id_publicacion) {
    return http().get('/api/info-post?id='+id_publicacion);
}


export function obtenerNumeroPublicaciones(){
    return http().get('/api/numero-posts');
}

export function meGustaComentario($data) {
    return http().post(
        '/api/me-gusta-comentario', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function registrarRespuestaComentarioPost($data){
    return http().post(
        '/api/guardar-respuesta-comentario-post', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function eliminarRespuesta(id_comentario) {
    return http().get('/api/eliminar-respuesta-comentario?id_comentario='+id_comentario);
}


export function editarRespuestaComentario($data){
    return http().post(
        '/api/editar-respuesta-comentario-post', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function editarComentario($data){
    return http().post(
        '/api/editar-comentario-post', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}
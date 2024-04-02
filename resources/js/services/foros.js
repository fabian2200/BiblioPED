import {http} from "./http_services";

export function foros(tipo) {
    return http().get('/api/foros?tipo='+tipo);
}

export function foro(id) {
    return http().get('/api/foro?id='+id);
}

export function guardarRespuesta($data) {
    return http().post(
        '/api/guardar-respuesta', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function guardarRespuestaComentario($data) {
    return http().post(
        '/api/guardar-respuesta-comentario', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function eliminarRespuestaComentario(id) {
    return http().get('/api/eliminar-respuesta?id='+id);
}

export function editarForo($data) {
    return http().post(
        '/api/editar-foro', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function cambiarEstadoForo(id, estado) {
    return http().get('/api/cambiar-estado?id='+id+"&estado_actual="+estado);
}

export function comentariosForos(id) {
    return http().get('/api/comentarios-foro?id='+id);
}

export function editarInfoForo($data) {
    return http().post(
        '/api/editar-info-foro', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}


export function eliminarRespuestaForo(id, id_foro) {
    return http().get('/api/eliminar-respuesta-foro?id='+id+'&id_foro='+id_foro);
}

export function editarRespuesta($data) {
    return http().post(
        '/api/editar-respuesta-foro', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}
import {http} from "./http_services";

export function historial(texto) {
    return http().get('/api/historial?texto='+texto);
}

export function eliminar_historial(tipo) {
    return http().get('/api/eliminar-historial?tipo='+tipo);
}

export function agregar_favorito($data) {
    return http().post(
        '/api/agregar-favorito', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function verificar_favorito(id) {
    return http().get('/api/verificar-favorito?id='+id);
}

export function eliminar_favorito(id) {
    return http().get('/api/eliminar-favorito?id='+id);
}

export function buscarFavoritos(texto) {
    return http().get('/api/mis-favoritos?texto='+texto);
}

export function misDatos() {
    return http().get('/api/mis-datos');
}

export function editar_usuario_estudiante($data) {
    return http().post(
        '/api/editar-usuario-estudiante', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function cambiar_password($data) {
    return http().post(
        '/api/cambiar-password', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function getSessionData() {
    return http().get('/api/session-data');
}

export function filtrarEstudiantes(grado, grupo, jornada) {
    return http().get('/api/estudiantes-compartir?grado='+grado+"&grupo="+grupo+"&jornada="+jornada);
}

export function compartirContenido($data) {
    return http().post(
        '/api/compartir-contenido', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}


export function recomendacionesDocente(texto) {
    return http().get('/api/recomendaciones-docente?texto='+texto);
}

export function eliminarRecomendaciones(tipo) {
    return http().get('/api/eliminar-recomendacion?tipo='+tipo);
}

export function recomendacionesEstudiante(texto) {
    return http().get('/api/recomendaciones-estudiante?texto='+texto);
}


export function verificarLogin() {
    return http().get('/api/verificarLogin');
}

export function crearForo($data) {
    return http().post(
        '/api/crear-foro', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function guardarSeleccion($data) {
    return http().post(
        '/api/guardar-seleccion',  
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function listarApuntes() {
    return http().get('/api/listarApuntes');
}

export function eliminarApunte(id) {
    return http().get('/api/eliminar-apunte?id='+id);
}

export function exportarApuntesPDF($data) {
    return http().post(
        '/api/pdf-apuntes',  
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function borrar_busquedas_seleccionadas($data) {
    return http().post(
        '/api/borrar-busquedas-seleccionadas', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function eliminarFavoritos($data) {
    return http().post(
        '/api/eliminar-favoritos', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

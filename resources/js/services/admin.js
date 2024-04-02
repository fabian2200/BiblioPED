import {http} from "./http_services";


export function registrar_docente($data) {
    return http().post(
        '/api/registro-docente', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function listarDocentes() {
    return http().get('/api/listar-docentes');
}

export function editar_docente($data) {
    return http().post(
        '/api/editar-docente', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}


export function guardarDatosContenido($data) {
    return http().post(
        '/api/guardar-contenido', 
        $data, 
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
    );
}

export function listarContenidoRegistrado() {
    return http().get('/api/listar-contenido-registrado');
}

export function editarDatosContenido($data) {
    return http().post(
        '/api/editar-contenido', 
        $data, 
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
    );
}

export function eliminarDatosContenido($data) {
    return http().post(
        '/api/eliminar-contenido', 
        $data, 
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
    );
}

export function listarEstudiantes() {
    return http().get('/api/listar-estudiantes');
}

export function registro_estudiante($data) {
    return http().post(
        '/api/registro-estudiante', 
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function editar_estudiante($data) {
    return http().post(
        '/api/editar-estudiante',  
        $data, 
        {
            headers: {
                'Content-Type': 'application/json'
            }
        }
    );
}

export function obtenerdatos() {
    return http().get('/api/datosDashboard');
}

export function estadisticaData() {
    return http().get('/api/estadisticaData');
}

export function infoColegio() {
    return http().get('/api/info-colegio');
}

export function editarInfoColegio($data) {
    return http().post(
        '/api/editar-info-colegio', 
        $data, 
        {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }
    );
}

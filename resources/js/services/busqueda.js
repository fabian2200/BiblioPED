import {http} from "./http_services";

export function busqueda($texto, $tipo, $pagina, $grado = 'no', $asignatura = 'no') {
    return http().get('/api/busqueda?textoBusqueda='+$texto+'&tipoBusqueda='+$tipo+'&pagina='+$pagina+'&asignatura='+$asignatura+'&grado='+$grado);
}

export function busquedaContenido($id, $tipo) {
    return http().get('/api/busqueda-contenido?id='+$id+'&tipo='+$tipo);
}

export function paginacion($texto, $tipo, $pagina, $grado = 'no', $asignatura = 'no') {
    return http().get('/api/paginacion?textoBusqueda='+$texto+'&tipoBusqueda='+$tipo+'&pagina='+$pagina+'&asignatura='+$asignatura+'&grado='+$grado);
}

export function paginacionMultimedia($texto, $tipo, $pagina,  $grado = 'no', $asignatura = 'no') {
    return http().get('/api/paginacion-multimedia?textoBusqueda='+$texto+'&tipoBusqueda='+$tipo+'&pagina='+$pagina+'&asignatura='+$asignatura+'&grado='+$grado);
}

export function verificarConexion() {
    return http().get('/api/check-connection');
}

export function buscarApuntes($id, $tipo) {
    return http().get('/api/busqueda-apunte?id='+$id+'&tipo='+$tipo);
}

export function corregirCadena($texto) {
    return http().get('/api/corregir-cadena?cadena='+$texto);
}
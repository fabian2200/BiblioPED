import {http} from "./http_services";

export function listarMentafactosAsignatura(asignatura) {
    return http().get('/api/listar-mentafactos?asignatura='+asignatura);
}
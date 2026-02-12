import { http } from "./http_services";
import axios from 'axios';

export function busqueda($texto, $tipo, $pagina, $grado = 'no', $asignatura = 'no') {
    return http().get('/api/busqueda?textoBusqueda=' + $texto + '&tipoBusqueda=' + $tipo + '&pagina=' + $pagina + '&asignatura=' + $asignatura + '&grado=' + $grado);
}

export function busquedaContenido($id, $tipo) {
    return http().get('/api/busqueda-contenido?id=' + $id + '&tipo=' + $tipo);
}

export function paginacion($texto, $tipo, $pagina, $grado = 'no', $asignatura = 'no') {
    return http().get('/api/paginacion?textoBusqueda=' + $texto + '&tipoBusqueda=' + $tipo + '&pagina=' + $pagina + '&asignatura=' + $asignatura + '&grado=' + $grado);
}

export function paginacionMultimedia($texto, $tipo, $pagina, $grado = 'no', $asignatura = 'no') {
    return http().get('/api/paginacion-multimedia?textoBusqueda=' + $texto + '&tipoBusqueda=' + $tipo + '&pagina=' + $pagina + '&asignatura=' + $asignatura + '&grado=' + $grado);
}

export function verificarConexion() {
    return http().get('/api/check-connection');
}

export function buscarApuntes($id, $tipo) {
    return http().get('/api/busqueda-apunte?id=' + $id + '&tipo=' + $tipo);
}

export async function corregirCadena(textoOriginal) {
    const url = "http://localhost:11434/api/generate";

    try {
        const { data } = await axios.post(url, {
            model: "qwen2.5:7b",
            prompt: `Corrige ortografía y gramática: "${textoOriginal}". Retorna solo el texto limpio, sin comillas y sin capitalizar.`,
            stream: false,
            options: {
                temperature: 0
            }
        }, {
            // Configuración crucial para evitar errores de CORS preflight
            headers: {
                'Content-Type': 'text/plain',
            }
        });

        const textoCorregido = data.response.trim();

        // 3. Verificación de si hubo cambios
        if (textoOriginal.trim() !== textoCorregido) {
            return {
                data: {
                    cadena: textoCorregido,
                    corregido: true,
                    success: true
                }
            }
        }

        return {
            data: {
                cadena: textoOriginal,
                corregido: false,
                success: true
            }
        }

    } catch (error) {
        return {
            data: {
                cadena: "Error al corregir el texto",
                corregido: false,
                success: false
            }
        }
    }
}
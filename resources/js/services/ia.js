export async function realizarResumen(textoOriginal, instruccionesusuario) {
    const url = "http://localhost:11434/api/generate";

    const prompt = `
        Eres un asistente experto en procesar textos en español y en hacer lo que te pida el usuario.

        Instrucciones QUE DEBES SEGUIR:
        - Amalisa primero el texto y luego haz lo que te pida el usuario.
        ${instruccionesusuario}
        - NO inventes información que no esté en el texto.
        - Mantén nombres, fechas, cifras y lugares EXACTOS.
        - No des opiniones personales.
        - Devuelve el resultado separado por parrafos y que se entienda bien.

        Texto a procesar:
        \"\"\"${textoOriginal}\"\"\"
    `;

    try {
        const { data } = await axios.post(url, {
            model: "qwen2.5:7b",
            prompt: prompt,
            stream: false,
            options: {
                temperature: 0.1,
                num_predict: 200-400
            }
        }, {
            // Configuración crucial para evitar errores de CORS preflight
            headers: {
                'Content-Type': 'text/plain',
            }
        });

        const resumen = data.response.trim();

        // 3. Verificación de si hubo cambios
        return {
            data: {
                cadena: resumen,
                resumido: true,
                success: true
            }
        }
    } catch (error) {
        return {
            data: {
                cadena: "Error al realizar el resumen",
                resumido: false,
                success: false
            }
        }
    }
}
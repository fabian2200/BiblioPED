export async function realizarResumenStreaming(textoOriginal, instruccionesusuario, onChunk){
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
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                model: "qwen2.5:3b",
                prompt: prompt,
                stream: true,
                options: {
                    temperature: 0.1,
                }
            })
        });

        const reader = response.body.getReader();
        const decoder = new TextDecoder("utf-8");

        while (true) {
            const { done, value } = await reader.read();
            if (done) break;

            const chunk = decoder.decode(value, { stream: true });

            const lineas = chunk.split("\n").filter(l => l.trim() !== "");

            for (const linea of lineas) {
                const json = JSON.parse(linea);

                if (json.response) {
                    onChunk(json.response);
                }
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
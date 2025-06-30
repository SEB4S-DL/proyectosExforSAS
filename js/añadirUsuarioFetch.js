const añadirUsuarioForm = document.getElementById("añadirUsuario"); // ✅ id corregido

if (añadirUsuarioForm) {
    const responseDiv = document.getElementById("respuesta") || document.createElement("div");
    if (!responseDiv.id) {
        responseDiv.id = "respuesta";
        añadirUsuarioForm.appendChild(responseDiv);
    }

    const submitBtn = añadirUsuarioForm.querySelector("button[type='submit']");

    añadirUsuarioForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const BASE_URL = window.location.origin + "/proyectosExforSAS/";
        const formData = new FormData(añadirUsuarioForm);

        const usuarioId = formData.get("usuario_id");
        const proyectoId = formData.get("proyecto_id");


        if (!usuarioId || !proyectoId) {
            responseDiv.textContent = "⚠️ Debes seleccionar un usuario.";
            responseDiv.style.color = "orange";
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = "Enviando...";


        fetch(BASE_URL + "functions/añadirUsuario.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(text => {
            console.log("📦 Respuesta cruda del backend:", text);

            try {
                const data = JSON.parse(text);
                console.log("✅ JSON parseado correctamente:", data);

                responseDiv.textContent = data.message;
                responseDiv.style.color = data.status === "success" ? "green" : "red";

                if (data.status === "success") {
                    añadirUsuarioForm.reset();
                    setTimeout(() => {
                        window.location.href = BASE_URL + "index.php";
                    }, 1200);
                }
            } catch (e) {
                console.error("❌ Error al parsear JSON:", e);
                console.error("❗ Contenido recibido:", text);
                responseDiv.textContent = "❌ El servidor no devolvió un JSON válido.";
                responseDiv.style.color = "red";
            }
        })
        .catch(error => {
            console.error("🔥 Error general en el fetch:", error);
            responseDiv.textContent = "❌ Error al enviar el formulario.";
            responseDiv.style.color = "red";
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.textContent = "Añadir usuario";
        });
    });
}

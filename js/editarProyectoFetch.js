const editarProyectoForm = document.getElementById("editarProyecto");

if (editarProyectoForm) {
    const responseDiv = document.getElementById("respuesta") || document.createElement("div");
    if (!responseDiv.id) {
        responseDiv.id = "respuesta";
        editarProyectoForm.appendChild(responseDiv);
    }

    const submitBtn = editarProyectoForm.querySelector("button[type='submit']");

    editarProyectoForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const BASE_URL = window.location.origin + "/proyectosExforSAS/";
        const formData = new FormData(editarProyectoForm);

        const nombre = formData.get("nombre")?.trim();

        if (!nombre) {
            responseDiv.textContent = "⚠️ El campo nombre es obligatorio.";
            responseDiv.style.color = "orange";
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = "Enviando...";

        fetch(BASE_URL + "functions/editarProyecto.php", {
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
                    Swal.fire({
                        title: "Proyecto actualizado ✅",
                        text: "Redirigiendo al inicio...",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1200,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

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
            submitBtn.textContent = "Editar proyecto";
        });
    });
}

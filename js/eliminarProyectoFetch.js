document.querySelectorAll(".eliminarProyecto").forEach(form => {
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const proyectoId = formData.get("id_proyecto");

        if (!proyectoId) {
            Swal.fire("❌ Error", "ID de proyecto no válido.", "error");
            return;
        }

        Swal.fire({
            title: "¿Estás seguro?",
            text: "Este proyecto será eliminado.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#7BDCB5",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminarlo",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(window.location.origin + "/proyectosExforSAS/functions/eliminarProyecto.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(text => {
                    try {
                        const data = JSON.parse(text);

                        Swal.fire({
                            title: data.status === "success" ? "¡Hecho!" : "Error",
                            text: data.message,
                            icon: data.status === "success" ? "success" : "error"
                        }).then(() => {
                            // 🔁 Recarga siempre, para reflejar el cambio
                            if (data.status === "success") {
                                location.reload();
                            }
                        });
                    } catch (err) {
                        console.error("❌ Error al parsear JSON:", text);
                        Swal.fire("Error", "Respuesta no válida del servidor.", "error");
                    }
                })
                .catch(error => {
                    console.error("🔥 Error en el fetch:", error);
                    Swal.fire("Error", "No se pudo enviar la solicitud.", "error");
                });
            }
        });
    });
});

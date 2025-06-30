
document.querySelectorAll(".form-eliminar-usuario").forEach(form => {
    form.addEventListener("submit", function(e) {
        e.preventDefault();

        const usuarioId = this.dataset.usuarioId;
        const proyectoId = this.dataset.proyectoId;

        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta acción desactivará al usuario del proyecto.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch("/proyectosExforSAS/functions/eliminarUsuarioDeProyecto.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `usuario_id=${usuarioId}&proyecto_id=${proyectoId}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        Swal.fire("¡Hecho!", data.message, "success").then(() => location.reload());
                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire("Error", "Hubo un problema al eliminar.", "error");
                });
            }
        });
    });
});

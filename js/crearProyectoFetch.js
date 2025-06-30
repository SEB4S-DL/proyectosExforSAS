const crearProyectoForm = document.getElementById("crearProyecto");

if (crearProyectoForm) {
    crearProyectoForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const nombre = document.getElementById("nombre").value.trim();
        const descripcion = document.getElementById("descripcion").value.trim();
        const responseDiv = document.getElementById("respuesta");

        const regexTexto = /^[a-zA-ZÀ-ÿ0-9\s.,_-]{3,100}$/;

        if (!nombre || !regexTexto.test(nombre)) {
            responseDiv.textContent = "⚠️ El nombre no es válido. Usa solo texto y al menos 3 caracteres.";
            responseDiv.style.color = "orange";
            return;
        }

        if (!descripcion || !regexTexto.test(descripcion)) {
            responseDiv.textContent = "⚠️ La descripción no es válida. Usa solo texto y evita símbolos raros.";
            responseDiv.style.color = "orange";
            return;
        }

        const formData = new FormData(this);
        const BASE_URL = window.location.origin + "/proyectosExforSAS/";

        fetch(BASE_URL + "functions/crearProyecto.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(text => {
            try {
                const data = JSON.parse(text);
                responseDiv.textContent = data.message;
                responseDiv.style.color = data.status === "success" ? "green" : "red";

                if (data.status === "success") {
                    this.reset();
                    setTimeout(() => {
                        window.location.href = BASE_URL + "index.php";
                    }, 1200);
                }
            } catch (err) {
                console.error("❌ Error al procesar la respuesta:", text);
                responseDiv.textContent = "❌ Ocurrió un error inesperado.";
                responseDiv.style.color = "red";
            }
        })
        .catch(err => {
            console.error("🔥 Error en fetch:", err);
            responseDiv.textContent = "❌ No se pudo enviar el formulario.";
            responseDiv.style.color = "red";
        });
    });
}

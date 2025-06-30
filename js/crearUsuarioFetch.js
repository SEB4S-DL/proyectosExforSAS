const crearUsuarioForm = document.getElementById("crearUsuario");

if (crearUsuarioForm) {
    crearUsuarioForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const nombre = document.getElementById("nombre").value.trim();
        const email = document.getElementById("email").value.trim();
        const responseDiv = document.getElementById("respuesta");

        const regexNombre = /^[a-zA-ZÀ-ÿ\s]{3,50}$/;
        const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!regexNombre.test(nombre)) {
            responseDiv.textContent = "⚠️ El nombre debe tener solo letras y mínimo 3 caracteres.";
            responseDiv.style.color = "orange";
            return;
        }

        if (!regexEmail.test(email)) {
            responseDiv.textContent = "⚠️ El email no es válido. Verifica el formato.";
            responseDiv.style.color = "orange";
            return;
        }

        const formData = new FormData(this);
        const BASE_URL = window.location.origin + "/proyectosExforSAS/";

        fetch(BASE_URL + "functions/crearUsuario.php", {
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

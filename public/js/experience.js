document.addEventListener("DOMContentLoaded", () => {
    const saveExperienceButton = document.getElementById('save-experience');
    // https://quilljs.com/playground/snow
    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    saveExperienceButton.addEventListener("click", async () => {
        const url = saveExperienceButton.getAttribute("data-url");
        const fields = ["role", "startExperienceDate", "endExperienceDate"];
        const experienceData = Object.fromEntries(fields.map(id => [id, document.getElementById(id).value]));
        experienceData.description = quill.root.innerHTML; // Obtener contenido de Quill.js como HTML
        try {
            const response = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(experienceData)
            });
            const data = await response.json();
            if (data.success) {
                console.log("Experience saved successfully!");
                fields.forEach(id => (document.getElementById(id).value = ""));
                quill.root.innerHTML = ""; // Vaciar Quill después de guardar
                loadExperience();
            } else {
                console.error("Error saving Experience.");
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });
    loadExperience();
});

function loadExperience() {
    const userExperienceDiv = document.getElementById("user-experience");
    const url = userExperienceDiv.getAttribute("data-url");

    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            userExperienceDiv.innerHTML = ''; // Limpiar contenido previo
            data.forEach(experience => {
                const item = document.createElement("div");
                item.classList.add("col-sm-6", "border"); // Agrega clases Bootstrap
                item.id = `experience-${experience.id}`; // Agrega el ID único
                const deleteUrl = `/user/delete-experience/${experience.id}`; // Ruta del backend
                item.innerHTML = `
                <div class="p-3">
                    <strong>${experience.role || "Sin especificar"}</strong> <br>
                    <small>(${formatDate(experience.start_date)} - ${formatDate(experience.end_date)})</small>
                    <span class="mt-2">${experience.description}</span> <!-- Permite HTML -->
                    <button 
                        class="btn btn-danger btn-sm mt-2" 
                        data-url="${deleteUrl}"  
                        onclick="deleteExperience(${experience.id}, this)">
                            Eliminar
                    </button>
                </div>
            `;
                userExperienceDiv.appendChild(item);
            });
        })
        .catch(error => console.error('Error:', error));
}

function formatDate(dateObj) {
    if (!dateObj || !dateObj.date) return "N/A"; // Maneja valores nulos o indefinidos
    const date = new Date(dateObj.date);
    if (isNaN(date.getTime())) return "Fecha inválida"; // Maneja errores de conversión
    // Formato DD-MM-YYYY
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

function deleteExperience(id, button) {
    if (!confirm("¿Estás seguro de que deseas eliminar esta experiencia?")) {
        return; // Detiene la ejecución si el usuario cancela
    }

    const deleteUrl = button.getAttribute("data-url");
    fetch(deleteUrl, {
        method: 'DELETE', // Asegura que el backend acepte DELETE, si no usa 'POST'
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`experience-${id}`).remove(); // Elimina del DOM si fue exitoso
            } else {
                alert("No tienes permiso para eliminar esta educación.");
            }
        })
        .catch(error => console.error('Error:', error));
}

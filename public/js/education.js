document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("save-education");
    const fields = ["degree", "startEducationDate", "endEducationDate", "almaMater"];

    btn.addEventListener("click", async () => {
        const url = btn.getAttribute("data-url");
        const data = Object.fromEntries(fields.map(id => [id, document.getElementById(id).value]));

        await Swal.fire({
            title: "Saving...",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
            timer: 1000,
            timerProgressBar: true
        });

        try {
            const res = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });

            const result = await res.json();

            if (result.success) {
                Swal.fire("Saved!", "Education saved.", "success");
                fields.forEach(id => (document.getElementById(id).value = ""));
                loadEducation();
            } else {
                Swal.fire("Error", "Could not save.", "error");
            }
        } catch (e) {
            Swal.fire("Error", e.message, "error");
        }
    });

    loadEducation();
});

function loadEducation() {
    const userEducationDiv = document.getElementById("user-education");
    const url = userEducationDiv.getAttribute("data-url");

    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            userEducationDiv.innerHTML = ''; // Limpiar contenido previo
            data.forEach(edu => {
                const item = document.createElement("div");
                item.classList.add("col-sm-4", "border"); // Se agregan las clases correctamente
                item.id = `education-${edu.id}`; // Agrega el ID único
                const deleteUrl = `/user/delete-education/${edu.id}`; // Ruta del backend
                item.innerHTML = `
                <div class="p-3">
                    <strong>${edu.degree}</strong> - ${edu.alma_mater} <br>
                    <small>(${formatDate(edu.start_date)} - ${formatDate(edu.end_date)})</small>
                    <button 
                        class="btn btn-danger btn-sm mt-2" 
                        data-url="${deleteUrl}"  
                        onclick="deleteEducation(${edu.id}, this)">
                            Eliminar
                    </button>
                </div>
            `;
                userEducationDiv.appendChild(item);
            });
        })
        .catch(error => console.error('Error:', error));
}

function formatDate(dateObj) {
    if (!dateObj || !dateObj.date) return "N/A"; // Maneja valores nulos o indefinidos
    const date = new Date(dateObj.date);
    if (isNaN(date.getTime())) return "Fecha inválida"; // Maneja errores de conversión
    // Formateo manual a DD-MM-YYYY
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0"); // +1 porque los meses van de 0 a 11
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

async function deleteEducation(id, button) {
    const url = button.getAttribute("data-url");

    const confirm = await Swal.fire({
        title: "Are you sure?",
        text: "This can't be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete"
    });

    if (!confirm.isConfirmed) return;

    await Swal.fire({
        title: "Deleting...",
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading(),
        timer: 1000,
        timerProgressBar: true
    });

    try {
        const res = await fetch(url, { method: "DELETE", headers: { Accept: "application/json" } });
        const data = await res.json();

        if (data.success) {
            Swal.fire("Deleted!", "Education removed.", "success");
            document.getElementById(`education-${id}`).remove();
        } else {
            Swal.fire("Denied", "No permission to delete.", "error");
        }
    } catch (e) {
        Swal.fire("Error", e.message, "error");
    }
}

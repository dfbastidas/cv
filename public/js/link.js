document.addEventListener("DOMContentLoaded", () => {
    const saveLinkButton = document.getElementById("save-link");
    saveLinkButton.addEventListener("click", async () => {
        await Swal.fire({
            title: "Saving...",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
            timer: 1000,
            timerProgressBar: true
        });
        const url = saveLinkButton.getAttribute("data-url");

        const fields = ["label", "link"];
        const linkData = Object.fromEntries(fields.map(id => [id, document.getElementById(id).value]));

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(linkData)
            });

            const data = await response.json();

            if (data.success) {
                Swal.fire("Saved!", "Link saved successfully!", "success");
                Swal.fire({
                    title: "Saved!",
                    text: "Link saved successfully.",
                    icon: "none" // Esto quita cualquier icono
                });
                fields.forEach(id => (document.getElementById(id).value = ""));
                loadLinks()
            } else {
                console.error("Error saving education.");
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });
    loadLinks()
});

function loadLinks() {
    const userLinkDiv = document.getElementById("user-link");
    const url = userLinkDiv.getAttribute("data-url");

    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            userLinkDiv.innerHTML = ''; // Limpiar contenido previo
            data.forEach(link => {
                const item = document.createElement("div");
                item.classList.add("col-sm-4", "border"); // Se agregan las clases correctamente
                item.id = `link-${link.id}`; // Agrega el ID único
                const deleteUrl = `/user/delete-link/${link.id}`; // Ruta del backend
                item.innerHTML = `
                <div class="p-3">
                    <a href="${link.link}" target="_blank">${link.label}</a>
                    <button 
                        class="btn btn-danger btn-sm mt-2" 
                        data-url="${deleteUrl}"  
                        onclick="deleteLink(${link.id}, this)">
                            Eliminar
                    </button>
                </div>
            `;
                userLinkDiv.appendChild(item);
            });
        })
        .catch(error => console.error('Error:', error));
}

async function deleteLink(id, button) {
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

                Swal.fire({
                    title: "Deleted!",
                    text: "Link removed.",
                    icon: "none" // Esto quita cualquier icono
                });
                document.getElementById(`link-${id}`).remove(); // Elimina del DOM si fue exitoso
            } else {
                alert("No tienes permiso para eliminar esta educación.");
            }
        })
        .catch(error => console.error('Error:', error));
}


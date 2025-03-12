document.addEventListener("DOMContentLoaded", () => {
    const saveEducationButton = document.getElementById("save-education");
    saveEducationButton.addEventListener("click", async () => {
        const url = saveEducationButton.getAttribute("data-url");

        const fields = ["degree", "startEducationDate", "endEducationDate", "almaMater"];
        const educationData = Object.fromEntries(fields.map(id => [id, document.getElementById(id).value]));

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(educationData)
            });

            const data = await response.json();

            if (data.success) {
                console.log("Education saved successfully!");
                fields.forEach(id => (document.getElementById(id).value = ""));
                loadEducation()
            } else {
                console.error("Error saving education.");
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });
    loadEducation()
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
                item.innerHTML = `
                <div class="p-3">
                    <strong>${edu.degree}</strong> - ${edu.alma_mater} <br>
                    <small>(${formatDate(edu.start_date)} - ${formatDate(edu.end_date)})</small>
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
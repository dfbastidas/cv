document.addEventListener("DOMContentLoaded", () => {

    const quill = new Quill('#editor', {
        theme: 'snow'
    });

    const saveExperienceButton = document.getElementById('save-experience');
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
                console.log("Education saved successfully!");
                fields.forEach(id => (document.getElementById(id).value = ""));
                quill.root.innerHTML = ""; // Vaciar Quill después de guardar
            } else {
                console.error("Error saving education.");
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });
});
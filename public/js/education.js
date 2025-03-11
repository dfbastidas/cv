document.addEventListener("DOMContentLoaded", () => {
    const saveEducationButton = document.getElementById("save-education");
    const saveExperienceButton = document.getElementById('save-experience');

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
            } else {
                console.error("Error saving education.");
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });


    saveExperienceButton.addEventListener("click", async () => {
        const url = saveExperienceButton.getAttribute("data-url");

        const fields = ["role", "startExperienceDate", "endExperienceDate", "description"];
        const experienceData = Object.fromEntries(fields.map(id => [id, document.getElementById(id).value]));

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
            } else {
                console.error("Error saving education.");
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });
});

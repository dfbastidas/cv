document.addEventListener("DOMContentLoaded", () => {
    const saveButton = document.getElementById("save-education");

    saveButton.addEventListener("click", async () => {
        const url = saveButton.getAttribute("data-url");

        const fields = ["degree", "startDate", "endDate", "almaMater"];
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
});

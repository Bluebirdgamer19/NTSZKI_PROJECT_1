const registrationsTableBody = document.getElementById("registrationsTableBody");
const statsTableBody = document.getElementById("statsTableBody");

function boolToHun(value) {
    return Number(value) === 1 ? "Igen" : "Nem";
}

function createCell(content, className = "") {
    const td = document.createElement("td");
    td.textContent = content;
    if (className !== "") {
        td.className = className;
    }
    return td;
}

async function deleteRegistration(id) {
    const response = await fetch("../server/registrations/delete.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    });
    return response.ok;
}

async function loadRegistrations() {
    registrationsTableBody.innerHTML = "";
    const response = await fetch("../server/registrations/getall.php");
    const registrations = await response.json();

    if (!Array.isArray(registrations) || registrations.length === 0) {
        const row = document.createElement("tr");
        row.appendChild(createCell("Nincs még regisztráció.", "empty-cell"));
        row.firstChild.colSpan = 8;
        registrationsTableBody.appendChild(row);
        return;
    }

    registrations.forEach((registration) => {
        const row = document.createElement("tr");
        row.appendChild(createCell(String(registration.id)));
        row.appendChild(createCell(registration.full_name));
        row.appendChild(createCell(registration.school_name));
        row.appendChild(createCell(registration.interests));
        row.appendChild(createCell(boolToHun(registration.is_dormitory)));
        row.appendChild(createCell(boolToHun(registration.is_final_year)));
        row.appendChild(createCell(registration.created_at));

        const actionCell = document.createElement("td");
        const deleteButton = document.createElement("button");
        deleteButton.type = "button";
        deleteButton.className = "danger-button";
        deleteButton.textContent = "Törlés";
        deleteButton.addEventListener("click", async () => {
            const deleted = await deleteRegistration(registration.id);
            if (deleted) {
                await loadRegistrations();
                await loadStats();
            } else {
                alert("A törlés nem sikerült.");
            }
        });
        actionCell.appendChild(deleteButton);
        row.appendChild(actionCell);
        registrationsTableBody.appendChild(row);
    });
}

async function loadStats() {
    statsTableBody.innerHTML = "";
    const response = await fetch("../server/registrations/stats.php");
    const stats = await response.json();

    if (!Array.isArray(stats) || stats.length === 0) {
        const row = document.createElement("tr");
        row.appendChild(createCell("Nincs megjeleníthető statisztika.", "empty-cell"));
        row.firstChild.colSpan = 5;
        statsTableBody.appendChild(row);
        return;
    }

    stats.forEach((item) => {
        const row = document.createElement("tr");
        row.appendChild(createCell(item.interest_name));
        row.appendChild(createCell(item.total_applicants));
        row.appendChild(createCell(item.final_year_applicants));
        row.appendChild(createCell(item.dormitory_applicants));
        row.appendChild(createCell(item.dormitory_final_year_applicants));
        statsTableBody.appendChild(row);
    });
}

loadRegistrations();
loadStats();

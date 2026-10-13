const form = document.getElementById("registrationForm");
const fullNameInput = document.getElementById("fullName");
const schoolNameInput = document.getElementById("schoolName");
const interestInput = document.getElementById("interestInput");
const addInterestButton = document.getElementById("addInterestButton");
const interestList = document.getElementById("interestList");
const formMessage = document.getElementById("formMessage");

const interests = [];

function renderInterests() {
    interestList.innerHTML = "";
    interests.forEach((interest, index) => {
        const item = document.createElement("li");
        item.className = "chip";
        item.innerHTML = `<span>${interest}</span>`;

        const removeButton = document.createElement("button");
        removeButton.type = "button";
        removeButton.textContent = "x";
        removeButton.addEventListener("click", () => {
            interests.splice(index, 1);
            renderInterests();
        });

        item.appendChild(removeButton);
        interestList.appendChild(item);
    });
}

function showMessage(text, status) {
    formMessage.textContent = text;
    formMessage.classList.remove("success", "error");
    formMessage.classList.add(status);
}

function addInterest() {
    const value = interestInput.value.trim();
    if (value === "") {
        showMessage("Adj meg egy szaknevet!", "error");
        return;
    }
    if (interests.includes(value)) {
        showMessage("Ez a szak már szerepel a listában.", "error");
        return;
    }
    interests.push(value);
    interestInput.selectedIndex = 0;
    showMessage("", "success");
    renderInterests();
}

addInterestButton.addEventListener("click", addInterest);

form.addEventListener("submit", async (event) => {
    event.preventDefault();

    if (interests.length === 0) {
        showMessage("Legalább egy szakot adj hozzá!", "error");
        return;
    }

    const selectedHousing = document.querySelector('input[name="housing"]:checked').value;
    const selectedFinalYear = document.querySelector('input[name="finalYear"]:checked').value;

    const payload = {
        fullName: fullNameInput.value.trim(),
        schoolName: schoolNameInput.value.trim(),
        interests,
        isDormitory: selectedHousing === "dormitory",
        isFinalYear: selectedFinalYear === "yes"
    };

    try {
        const response = await fetch("../server/registrations/create.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(payload)
        });

        if (!response.ok) {
            showMessage("Mentés sikertelen. Ellenőrizd az adatokat!", "error");
            return;
        }

        fullNameInput.value = "";
        schoolNameInput.value = "";
        interests.length = 0;
        renderInterests();
        document.querySelector('input[name="housing"][value="dormitory"]').checked = true;
        document.querySelector('input[name="finalYear"][value="yes"]').checked = true;
        showMessage("Sikeres jelentkezés!", "success");
    } catch (error) {
        showMessage("Hálózati hiba történt, próbáld újra.", "error");
    }
});

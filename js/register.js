document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("registerForm");

    function showError(id, msg) {
        const input = document.getElementById(id);
        const error = document.getElementById(id + "-error");
        input.classList.add("input-error");
        error.textContent = msg;
    }

    function clearError(id) {
        const input = document.getElementById(id);
        const error = document.getElementById(id + "-error");
        input.classList.remove("input-error");
        error.textContent = "";
    }

    function validateField(id, validator) {
        const input = document.getElementById(id);
        input.addEventListener("input", () => {
            const message = validator(input.value.trim());
            if (message) showError(id, message);
            else clearError(id);
        });
    }

    validateField("fullname", v => v.length < 3 ? "Enter a valid name." : "");
    validateField("address", v => v.length > 0 && v.length < 5 ? "Address too short." : "");
    validateField("phone", v => v && !/^(\+?\d{7,12})$/.test(v) ? "Invalid phone number." : "");
    validateField("email", v => !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? "Invalid email." : "");
    validateField("username", v => v.length < 4 ? "Username must be 4+ characters." : "");
    validateField("password", v => v.length < 8 ? "Password must be 8+ characters." : "");
    validateField("confirm-password", v => v !== document.getElementById("password").value ? "Passwords do not match." : "");

    form.addEventListener("submit", e => {
        let fields = ["fullname", "address", "phone", "email", "username", "password", "confirm-password"];
        let stop = false;

        fields.forEach(id => {
            document.getElementById(id).dispatchEvent(new Event("input"));
            if (document.getElementById(id + "-error").textContent !== "") stop = true;
        });

        if (stop) {
            e.preventDefault();
            alert("Please fix the errors.");
        }
    });
});

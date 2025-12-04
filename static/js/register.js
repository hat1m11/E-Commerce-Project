document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("registerForm");

    // Show an error message
    function showError(inputId, message) {
        const input = document.getElementById(inputId);
        const errorMsg = document.getElementById(inputId + "-error");

        input.classList.add("input-error");
        errorMsg.textContent = message;
    }

    // Clear an error message
    function clearError(inputId) {
        const input = document.getElementById(inputId);
        const errorMsg = document.getElementById(inputId + "-error");

        input.classList.remove("input-error");
        errorMsg.textContent = "";
    }

    // Validate as user types
    function validateField(inputId, validator) {
        const input = document.getElementById(inputId);
        input.addEventListener("input", () => {
            const error = validator(input.value.trim());
            if (error) showError(inputId, error);
            else clearError(inputId);
        });
    }

    validateField("fullname", (value) => {
        if (value.length === 0) return "Full name is required.";
        if (value.length > 40) return "Full name cannot exceed 40 characters.";
        return "";
    });

    validateField("address", (value) => {
        if (value.length === 0) return "Address is required.";
        if (value.length > 30) return "Address cannot exceed 30 characters.";
        return "";
    });

    validateField("phone", (value) => {
        const phoneRegex = /^(\+\d{1,3}[- ]?)?\d{7,12}$/;
        if (!phoneRegex.test(value)) return "Enter a valid phone number.";
        return "";
    });

    validateField("email", (value) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) return "Enter a valid email address.";
        return "";
    });

    validateField("password", (value) => {
        if (value.length < 6) return "Password must be at least 6 characters.";
        return "";
    });

    validateField("confirm-password", (value) => {
        const password = document.getElementById("password").value;
        if (value !== password) return "Passwords do not match.";
        return "";
    });

    // Check everything before submit
    form.addEventListener("submit", (e) => {
        const inputs = ["fullname", "address", "phone", "email", "password", "confirm-password"];
        let stopSubmit = false;

        inputs.forEach((id) => {
            const input = document.getElementById(id);
            input.dispatchEvent(new Event("input")); // force validation

            if (document.getElementById(id + "-error").textContent !== "") {
                stopSubmit = true;
            }
        });

        if (stopSubmit) {
            e.preventDefault();
            alert("Please fix errors before submitting.");
        }
    });

});

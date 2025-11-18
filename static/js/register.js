document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("registerForm");

    // Helper function to show an error
    function showError(inputId, message) {
        const input = document.getElementById(inputId);
        const errorMsg = document.getElementById(inputId + "-error");

        input.classList.add("input-error");
        errorMsg.textContent = message;
    }

    // Helper function to clear an error
    function clearError(inputId) {
        const input = document.getElementById(inputId);
        const errorMsg = document.getElementById(inputId + "-error");

        input.classList.remove("input-error");
        errorMsg.textContent = "";
    }

    // Live validation function
    function validateField(inputId, validator) {
        const input = document.getElementById(inputId);
        input.addEventListener("input", () => {
            const error = validator(input.value.trim());
            if (error) showError(inputId, error);
            else clearError(inputId);
        });
    }

    // ---------- VALIDATION RULES ----------

    // Full Name (max 20 chars)
    validateField("fullname", (value) => {
        if (value.length === 0) return "Full name is required.";
        if (value.length > 40) return "Full name cannot exceed 40 characters.";
        return "";
    });

    // Address
    validateField("address", (value) => {
        if (value.length === 0) return "Address is required.";
        if (value.length > 30) return "Address cannot exceed 30 characters.";
        return "";
    });

    // Phone Number
    validateField("phone", (value) => {
        const phoneRegex = /^(\+\d{1,3}[- ]?)?\d{7,12}$/;
        if (!phoneRegex.test(value)) {
            return "Enter a valid phone number (e.g. +44 7123456789).";
        }
        return "";
    });

    // Email
    validateField("email", (value) => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            return "Enter a valid email address.";
        }
        return "";
    });

    // Password
    validateField("password", (value) => {
        if (value.length < 6) return "Password must be at least 6 characters.";
        return "";
    });

    // Confirm Password
    validateField("confirm-password", (value) => {
        const password = document.getElementById("password").value;
        if (value !== password) return "Passwords do not match.";
        return "";
    });

    // Final validation before submitting
    form.addEventListener("submit", (e) => {
        const inputs = ["fullname", "address", "phone", "email", "password", "confirm-password"];
        let stopSubmit = false;

        inputs.forEach((id) => {
            const input = document.getElementById(id);
            input.dispatchEvent(new Event("input")); // force check

            if (document.getElementById(id + "-error").textContent !== "") {
                stopSubmit = true;
            }
        });

        if (stopSubmit) {
            e.preventDefault();
            alert("Please fix the highlighted errors before submitting.");
        }
    });

});

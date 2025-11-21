document.addEventListener("DOMContentLoaded", () => {

    // ----------------------------------
    // BEAUTIFUL SUCCESS TOAST MESSAGE
    // ----------------------------------
    function showToast(message) {
        const toast = document.createElement("div");
        toast.className = "toast-message";
        toast.innerHTML = `
            <span class="toast-icon">✔</span>
            <span>${message}</span>
        `;

        document.body.appendChild(toast);

        // Show animation
        setTimeout(() => toast.classList.add("show"), 10);

        // Hide animation
        setTimeout(() => {
            toast.classList.remove("show");
            setTimeout(() => toast.remove(), 300);
        }, 2500);
    }


    // ----------------------------------
    // ADD TO CART BUTTONS
    // ----------------------------------
    const addButtons = document.querySelectorAll(".add-btn");

    addButtons.forEach(btn => {
        btn.addEventListener("click", () => {

            const name = btn.dataset.name;

            const formData = new FormData();
            formData.append("id", btn.dataset.id);
            formData.append("name", btn.dataset.name);
            formData.append("price", btn.dataset.price);
            formData.append("image", btn.dataset.image);

            fetch("/E-Commerce-Project/add_to_cart.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(() => {
                showToast(`${name} was added to your cart successfully!`);
            })
            .catch(err => console.error("ADD ERROR:", err));
        });
    });

});

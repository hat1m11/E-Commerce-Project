console.log("cart.js is loaded!");

document.addEventListener("DOMContentLoaded", () => {

    // Add to cart buttons
    const addButtons = document.querySelectorAll(".add-btn");

    addButtons.forEach(btn => {
        btn.addEventListener("click", () => {

            const name = btn.dataset.name;

            // Data to send
            const formData = new FormData();
            formData.append("id", btn.dataset.id);
            formData.append("name", btn.dataset.name);
            formData.append("price", btn.dataset.price);
            formData.append("image", btn.dataset.image);

            // Send to server
            fetch("add_to_cart.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(resText => {
                if (resText.trim() === "OK") {

                    // Quick success message
                    const msg = document.createElement("p");
                    msg.textContent = `${name} was added to your cart!`;
                    msg.style.color = "green";
                    msg.style.fontWeight = "bold";
                    msg.style.marginTop = "10px";
                    document.body.appendChild(msg);

                    setTimeout(() => msg.remove(), 3000);
                } else {
                    console.error("Unexpected response:", resText);
                }
            })
            .catch(err => console.error("Add error:", err));
        });
    });

    // Remove from cart buttons
    const removeButtons = document.querySelectorAll(".remove-item");

    removeButtons.forEach(btn => {
        btn.addEventListener("click", () => {

            const index = btn.dataset.index;

            // Data to send
            const formData = new FormData();
            formData.append("index", index);

            // Send remove request
            fetch("remove_from_cart.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(() => window.location.reload())
            .catch(err => console.error("Remove error:", err));
        });
    });
});

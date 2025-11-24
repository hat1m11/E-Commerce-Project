console.log("cart.js is loaded!");

document.addEventListener("DOMContentLoaded", () => {

    /* =====================================
       ADD TO CART BUTTONS
    ====================================== */
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

                // Added message
                const msg = document.createElement("p");
                msg.textContent = `${name} was added to your cart!`;
                msg.style.color = "green";
                msg.style.fontWeight = "bold";
                msg.style.marginTop = "10px";

                document.body.appendChild(msg);

                setTimeout(() => msg.remove(), 3000);

            })
            .catch(err => console.error("ADD ERROR:", err));
        });
    });



    /* =====================================
       REMOVE FROM CART BUTTONS
    ====================================== */
    const removeButtons = document.querySelectorAll(".remove-btn");

    removeButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            console.log("Remove button clicked!", btn.dataset.index);
            
            const index = btn.dataset.index;

            const formData = new FormData();
            formData.append("index", index);

            fetch("remove_from_cart.php", {
            method: "POST",
            body: formData
            })

            .then(res => res.text())
            .then(() => {
                // Reload page to refresh cart visually
                window.location.reload();
            })
            .catch(err => console.error("REMOVE ERROR:", err));
        });
    });

});

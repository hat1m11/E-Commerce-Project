console.log("cart.js loaded");

document.addEventListener("click", (event) => {
    if (event.target.classList.contains("add-btn")) {
        const btn = event.target;

        const formData = new FormData();
        formData.append("id", btn.dataset.id);
        formData.append("name", btn.dataset.name);
        formData.append("price", btn.dataset.price);
        formData.append("image", btn.dataset.image);
        formData.append("size", btn.dataset.size || "N/A");
        formData.append("qty", btn.dataset.qty || 1);

        fetch("add_to_cart.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.text())
        .then(text => {
            console.log("Add-to-cart response:", text);

            if (text.trim() === "OK") {
                alert("Item added to cart");
            } else {
                console.error("Add-to-cart failed:", text);
            }
        })
        .catch(err => console.error("Add to cart error:", err));
    }
});
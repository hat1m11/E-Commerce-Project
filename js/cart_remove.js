document.addEventListener("DOMContentLoaded", () => {
    document.addEventListener("click", (event) => {
        const removeBtn = event.target.closest(".remove-item");
        const qtyBtn = event.target.closest(".qty-btn");

        if (removeBtn) {
            const cartItem = removeBtn.closest(".cart-item");
            if (!cartItem) return;

            const form = new FormData();

            if (cartItem.dataset.basketId) {
                form.append("basket_item_id", cartItem.dataset.basketId);
            } else if (cartItem.dataset.index) {
                form.append("index", cartItem.dataset.index);
            } else {
                console.error("No basket ID or index found for remove.");
                return;
            }

            cartItem.classList.add("removing");

            fetch("remove_from_cart.php", {
                method: "POST",
                body: form
            })
            .then(res => res.text())
            .then(result => {
                if (result.trim() === "OK") {
                    cartItem.remove();
                    updateTotal();
                } else {
                    cartItem.classList.remove("removing");
                    console.error("Remove failed:", result);
                }
            })
            .catch(err => {
                cartItem.classList.remove("removing");
                console.error("Remove error:", err);
            });

            return;
        }

        if (qtyBtn) {
            const cartItem = qtyBtn.closest(".cart-item");
            if (!cartItem) return;

            const qtySpan = cartItem.querySelector(".qty-number");
            let qty = parseInt(qtySpan.textContent, 10) || 1;

            if (qtyBtn.classList.contains("plus")) qty++;
            if (qtyBtn.classList.contains("minus") && qty > 1) qty--;

            qtySpan.textContent = qty;
            cartItem.dataset.qty = qty;
            updateTotal();

            const form = new FormData();

            if (cartItem.dataset.basketId) {
                form.append("basket_item_id", cartItem.dataset.basketId);
            } else if (cartItem.dataset.index) {
                form.append("index", cartItem.dataset.index);
            } else {
                console.error("No basket ID or index found for quantity update.");
                return;
            }

            form.append("qty", qty);

            fetch("update_cart.php", {
                method: "POST",
                body: form
            })
            .then(res => res.text())
            .then(result => {
                if (result.trim() !== "OK") {
                    console.error("Update failed:", result);
                }
            })
            .catch(err => {
                console.error("Update error:", err);
            });

            return;
        }
    });

    function updateTotal() {
        let total = 0;

        document.querySelectorAll(".cart-item").forEach(item => {
            const price = parseFloat(item.dataset.price || "0");
            const qty = parseInt(item.querySelector(".qty-number")?.textContent || "1", 10);
            total += price * qty;
        });

        const totalElem = document.querySelector(".total-price");
        if (totalElem) {
            totalElem.textContent = "£" + total.toFixed(2);
        }
    }

    updateTotal();
});
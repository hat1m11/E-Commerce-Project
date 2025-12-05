document.addEventListener("DOMContentLoaded", () => {

    // Remove items with fade-out
    const removeBtns = document.querySelectorAll(".remove-item");

    removeBtns.forEach(btn => {
        btn.addEventListener("click", () => {

            const index = btn.dataset.index;
            const itemDiv = btn.closest(".cart-item");

            itemDiv.classList.add("removing"); // fade-out class

            setTimeout(() => {
                const form = new FormData();
                form.append("index", index);

                fetch("remove_from_cart.php", {
                    method: "POST",
                    body: form
                })
                .then(res => res.text())
                .then(result => {
                    if (result.trim() === "OK") {
                        itemDiv.remove();
                        updateTotal();
                    } else {
                        console.error("Remove returned:", result);
                    }
                })
                .catch(err => console.error("Remove error:", err));

            }, 400);
        });
    });

    // Quantity buttons
    document.querySelectorAll(".qty-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const parent = btn.closest(".cart-item");
            const span = parent.querySelector(".qty-number");

            let qty = parseInt(span.textContent);
            if (btn.classList.contains("plus")) qty++;
            if (btn.classList.contains("minus") && qty > 1) qty--;

            span.textContent = qty;
            updateTotal();
        });
    });

    // Calculate total price
    function updateTotal() {
        let total = 0;

        document.querySelectorAll(".cart-item").forEach(item => {
            const price = parseFloat(item.dataset.price);
            const qtySpan = item.querySelector(".qty-number");
            const qty = qtySpan ? parseInt(qtySpan.textContent) : 1;

            total += price * qty;
        });

        const totalElem = document.querySelector(".total-price");
        if (totalElem) totalElem.textContent = "£" + total.toFixed(2);
    }

    updateTotal();
});


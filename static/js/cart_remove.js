document.addEventListener("DOMContentLoaded", () => {

    /* ============================
       REMOVE ITEM WITH ANIMATION
    ============================ */
    const removeBtns = document.querySelectorAll(".remove-item");

    removeBtns.forEach(btn => {
        btn.addEventListener("click", () => {

            const index = btn.dataset.index;
            const itemDiv = btn.closest(".cart-item");

            // Fade-out animation
            itemDiv.classList.add("removing");

            setTimeout(() => {

                const form = new FormData();
                form.append("index", index); // IMPORTANT

                fetch("/E-Commerce-Project/remove_from_cart.php", {
                    method: "POST",
                    body: form
                })
                .then(res => res.text())
                .then(result => {
                    if (result === "OK") {
                        itemDiv.remove();
                        updateTotal();
                    }
                });

            }, 400);
        });
    });


    /* ============================
       QUANTITY BUTTONS
    ============================ */
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


    /* ============================
       UPDATE TOTAL PRICE
    ============================ */
    function updateTotal() {
        let total = 0;

        document.querySelectorAll(".cart-item").forEach(item => {

            const price = parseFloat(item.dataset.price);
            const qty = parseInt(
                item.querySelector(".qty-number").textContent
            );

            total += price * qty;
        });

        document.querySelector(".total-price").textContent =
            "£" + total.toFixed(2);
    }

    updateTotal();
});

document.addEventListener("DOMContentLoaded", () => {
    const typeFilter = document.getElementById("typeFilter");
    const sortSelect = document.getElementById("sortSelect");
    const productGrid = document.querySelector(".products-grid");

    const BASE_URL = window.BASE_URL || "";

    const products = [
        { id: 501, name: "Street Trainers", price: 64.99, type: "Trainers", image: BASE_URL + "/images/trainer1.jpeg", date: "2026-03-03" },
        { id: 502, name: "High-Top Sneakers", price: 69.99, type: "Sneakers", image: BASE_URL + "/images/hightop1.jpeg", date: "2026-02-28" },
        { id: 503, name: "Everyday Slides", price: 24.99, type: "Slides", image: BASE_URL + "/images/slides1.jpeg", date: "2026-02-21" },
        { id: 504, name: "Runner Trainers", price: 59.99, type: "Runners", image: BASE_URL + "/images/runner1.jpeg", date: "2026-02-15" },
        { id: 505, name: "Urban Boots", price: 79.99, type: "Boots", image: BASE_URL + "/images/boots1.jpeg", date: "2026-02-08" }
    ];

    function renderProducts(list) {
        productGrid.innerHTML = "";
        list.forEach(prod => {
            const card = document.createElement("div");
            card.className = "product-card";

            card.innerHTML = `
                <a href="${BASE_URL}/single_product.php?id=${prod.id}">
                    <img src="${prod.image}" alt="${prod.name}">
                </a>
                <h3>${prod.name}</h3>
                <p class="price">£${prod.price.toFixed(2)}</p>

                <button class="add-btn"
                    data-id="${prod.id}"
                    data-name="${prod.name}"
                    data-price="${prod.price}"
                    data-image="${prod.image}">
                    Add to Cart
                </button>
            `;

            productGrid.appendChild(card);
        });
    }

    function filterAndSort() {
        let filtered = [...products];

        if (typeFilter.value !== "All") {
            filtered = filtered.filter(p => p.type === typeFilter.value);
        }

        if (sortSelect.value === "priceLow") {
            filtered.sort((a, b) => a.price - b.price);
        } else if (sortSelect.value === "priceHigh") {
            filtered.sort((a, b) => b.price - a.price);
        } else if (sortSelect.value === "newest") {
            filtered.sort((a, b) => new Date(b.date) - new Date(a.date));
        }

        renderProducts(filtered);
    }

    typeFilter.addEventListener("change", filterAndSort);
    sortSelect.addEventListener("change", filterAndSort);

    renderProducts(products);
});
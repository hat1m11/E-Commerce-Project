document.addEventListener("DOMContentLoaded", () => {
    const typeFilter = document.getElementById("typeFilter");
    const sortSelect = document.getElementById("sortSelect");
    const productGrid = document.querySelector(".products-grid");

    const BASE_URL = window.BASE_URL || "";

    const products = [
        { id: 301, name: "Kids Hoodie 1", price: 29.99, type: "Hoodie", image: BASE_URL + "/images/kidshoodie1.jpeg", date: "2026-03-01" },
        { id: 302, name: "Kids Tracksuit", price: 44.99, type: "Tracksuit", image: BASE_URL + "/images/kidstracksuit1.jpeg", date: "2026-02-26" },
        { id: 303, name: "Kids T-shirt 1", price: 16.99, type: "T-shirt", image: BASE_URL + "/images/kidtshirt1.jpeg", date: "2026-03-03" },
        { id: 304, name: "Kids Puffer Jacket", price: 49.99, type: "Jacket", image: BASE_URL + "/images/kidsjacket1.jpeg", date: "2026-02-20" },
        { id: 305, name: "Kids Joggers", price: 24.99, type: "Joggers", image: BASE_URL + "/images/kidsjoggers1.jpeg", date: "2026-02-12" }
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
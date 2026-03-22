document.addEventListener("DOMContentLoaded", () => {

    const typeFilter = document.getElementById("typeFilter");
    const sortSelect = document.getElementById("sortSelect");
    const productGrid = document.querySelector(".products-grid");

    const BASE_URL = window.BASE_URL || "";

    const products = [
        { id: 401, name: "Signature Cap", price: 18.99, type: "Cap", image: BASE_URL + "/images/cap1.jpeg", date: "2026-03-02" },
        { id: 402, name: "Everyday Beanie", price: 16.99, type: "Beanie", image: BASE_URL + "/images/beanie1.jpeg", date: "2026-02-25" },
        { id: 403, name: "Crossbody Bag", price: 29.99, type: "Bag", image: BASE_URL + "/images/bag1.jpeg", date: "2026-03-03" },
        { id: 404, name: "Crew Socks Pack", price: 12.99, type: "Socks", image: BASE_URL + "/images/socks1.jpeg", date: "2026-02-18" },
        { id: 405, name: "Utility Belt", price: 14.99, type: "Belt", image: BASE_URL + "/images/belt1.jpeg", date: "2026-02-10" }
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
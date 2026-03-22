document.addEventListener("DOMContentLoaded", () => {

    const typeFilter = document.getElementById("typeFilter");
    const sortSelect = document.getElementById("sortSelect");
    const productGrid = document.querySelector(".products-grid");

    const BASE_URL = window.BASE_URL || "";

    const products = [
        { id: 4, name: "Men's Hoodie 1", price: 39.99, type: "Hoodie", image: BASE_URL + "/images/hoodie1.jpeg", date: "2025-10-01" },
        { id: 5, name: "Men's Tracksuit", price: 59.99, type: "Tracksuit", image: BASE_URL + "/images/mtracksuit1.jpeg", date: "2025-09-20" },
        { id: 6, name: "Men's T-shirt 1", price: 24.99, type: "T-shirt", image: BASE_URL + "/images/mtshirt1.jpeg", date: "2025-11-03" },
        { id: 7, name: "Men's Hoodie 2", price: 49.99, type: "Hoodie", image: BASE_URL + "/images/hoodie2.jpeg", date: "2025-08-17" },
        { id: 8, name: "Men's T-shirt 2", price: 22.99, type: "T-shirt", image: BASE_URL + "/images/mtshirt2.jpeg", date: "2025-07-29" }
    ];

    function renderProducts(list) {
        productGrid.innerHTML = "";

        list.forEach(prod => {
            const card = document.createElement("div");
            card.className = "product-card";

            card.innerHTML = `
                <a href="single_product.php?id=${prod.id}">
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
        let filtered = products.slice();

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
document.addEventListener("DOMContentLoaded", () => {

    const typeFilter = document.getElementById("typeFilter");
    const sortSelect = document.getElementById("sortSelect");
    const productGrid = document.querySelector(".products-grid");

    const BASE_URL = window.BASE_URL || "";

    const products = [
        {
            id: "w_hoodie1",
            name: "6ixe7ven Hoodie 1",
            price: 39.99,
            type: "Hoodie",
            sizes: ["S", "M", "L"],
            image: BASE_URL + "/static/images/hoodie4.jpeg",
            date: "2025-10-01"
        },
        {
            id: "w_jeans1",
            name: "6ixe7ven Jeans 1",
            price: 49.99,
            type: "Jeans",
            sizes: ["S", "M", "L"],
            image: BASE_URL + "/static/images/jeans1.jpeg",
            date: "2025-09-15"
        },
        {
            id: "w_tshirt1",
            name: "6ixe7ven T-shirt 1",
            price: 19.99,
            type: "T-shirt",
            sizes: ["S", "M", "L"],
            image: BASE_URL + "/static/images/tshirt1.jpeg",
            date: "2025-11-05"
        },
        {
            id: "w_hoodie2",
            name: "6ixe7ven Hoodie 2",
            price: 39.99,
            type: "Hoodie",
            sizes: ["S", "M", "L"],
            image: BASE_URL + "/static/images/hoodie5.jpeg",
            date: "2025-08-20"
        },
        {
            id: "w_tshirt2",
            name: "6ixe7ven T-shirt 2",
            price: 19.99,
            type: "T-shirt",
            sizes: ["S", "M", "L"],
            image: BASE_URL + "/static/images/tshirt2.jpeg",
            date: "2025-07-30"
        }
    ];

    function renderProducts(list) {
        productGrid.innerHTML = "";
        list.forEach(prod => {
            const card = document.createElement("div");
            card.className = "product-card";
            card.innerHTML = `
                <img src="${prod.image}" alt="${prod.name}">
                <h3>${prod.name}</h3>
                <p class="price">Â£${prod.price.toFixed(2)}</p>
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

        // Filter by type
        if (typeFilter.value !== "All") {
            filtered = filtered.filter(p => p.type === typeFilter.value);
        }

        // Sort
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

    // Initial render
    renderProducts(products);
});
document.addEventListener("DOMContentLoaded", () => {
    
    const typeFilter = document.getElementById("typeFilter");
    const sortSelect = document.getElementById("sortSelect");
    const productGrid = document.querySelector(".products-grid");

    const products = [
        {id: "shoe_men_trainer1", name: "Menâ€™s Running Trainer", price: 59.99, gender: "Men", image: "/static/images/mens_trainer.jpeg", date: "2025-10-01"},
        {id: "shoe_women_boot1", name: "Womenâ€™s Winter Boot", price: 69.99, gender: "Women", image: "/static/images/women_boot.jpeg", date: "2025-09-18"},
        {id: "shoe_men_slides1", name: "Menâ€™s Sport Slides", price: 24.99, gender: "Men", image: "/static/images/mens_slides.jpeg", date: "2025-11-03"},
        {id: "shoe_women_slides1", name: "Womenâ€™s Soft Slides", price: 22.99, gender: "Women", image: "/static/images/women_slides.jpeg", date: "2025-08-12"},
        {id: "shoe_women_trainer1", name: "Womenâ€™s Running Trainer", price: 54.99, gender: "Women", image: "/static/images/women_trainer.jpeg", date: "2025-07-22"}
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
        let filtered = products;

        if (typeFilter.value !== "All") {
            filtered = filtered.filter(p => p.gender === typeFilter.value);
        }

        if (sortSelect.value === "priceLow") {
            filtered.sort((a, b) => a.price - b.price);
        } 
        else if (sortSelect.value === "priceHigh") {
            filtered.sort((a, b) => b.price - a.price);
        } 
        else if (sortSelect.value === "newest") {
            filtered.sort((a, b) => new Date(b.date) - new Date(a.date));
        }

        renderProducts(filtered);
    }

    typeFilter.addEventListener("change", filterAndSort);
    sortSelect.addEventListener("change", filterAndSort);

    renderProducts(products);
});
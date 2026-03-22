document.addEventListener("DOMContentLoaded", () => {

    const typeFilter  = document.getElementById("typeFilter");
    const sortSelect  = document.getElementById("sortSelect");   
    const productGrid = document.querySelector(".products-grid");

    let products = Array.from(document.querySelectorAll(".product-card"));

    function updateProducts() {
        let selectedType = typeFilter.value;
        let sortOption   = sortSelect.value;

        let filtered = products;
        if (selectedType !== "All") {
            filtered = filtered.filter(p => p.dataset.type === selectedType);
        }

        filtered.sort((a, b) => {
            let priceA = parseFloat(a.querySelector(".price").innerText.replace("£", ""));
            let priceB = parseFloat(b.querySelector(".price").innerText.replace("£", ""));

            if (sortOption === "priceLow")  return priceA - priceB;
            if (sortOption === "priceHigh") return priceB - priceA;
            if (sortOption === "newest")    return products.indexOf(b) - products.indexOf(a);
            return 0;
        });

        productGrid.innerHTML = "";
        filtered.forEach(p => productGrid.appendChild(p));
    }

    const urlParams = new URLSearchParams(window.location.search);
    const urlType   = urlParams.get("type");
    if (urlType) {
        const match = Array.from(typeFilter.options).find(o => o.value === urlType);
        if (match) {
            typeFilter.value = urlType;
            updateProducts();
        }
    }

    typeFilter.addEventListener("change", updateProducts);
    sortSelect.addEventListener("change", updateProducts);   
});
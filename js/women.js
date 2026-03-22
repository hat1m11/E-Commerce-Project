document.addEventListener("DOMContentLoaded", () => {
  const typeFilter = document.getElementById("typeFilter");
  const sortSelect = document.getElementById("sortSelect");
  const productGrid = document.querySelector(".products-grid");

  const BASE_URL = window.BASE_URL;

  const products = [
    {
      id: 201,
      name: "Women's Hoodie 1",
      price: 39.99,
      type: "Hoodie",
      image: BASE_URL + "/images/whoodie1.jpeg",
      date: "2025-10-01"
    },
    {
      id: 202,
      name: "Women's Jeans",
      price: 49.99,
      type: "Jeans",
      image: BASE_URL + "/images/wjeans1.jpeg",
      date: "2025-09-15"
    },
    {
      id: 203,
      name: "Women's T-shirt 1",
      price: 19.99,
      type: "T-shirt",
      image: BASE_URL + "/images/wtshirt1.jpeg",
      date: "2025-11-05"
    },
    {
      id: 204,
      name: "Women's Hoodie 2",
      price: 44.99,
      type: "Hoodie",
      image: BASE_URL + "/images/whoodie2.jpeg",
      date: "2025-08-20"
    },
    {
      id: 205,
      name: "Women's T-shirt 2",
      price: 19.99,
      type: "T-shirt",
      image: BASE_URL + "/images/wtshirt2.jpeg",
      date: "2025-07-30"
    }
  ];

  function renderProducts(list) {
    productGrid.innerHTML = "";
    list.forEach(prod => {
      const card = document.createElement("div");
      card.className = "product-card";
      card.innerHTML = `
        <a href="${BASE_URL}/single_product.php?id=${prod.id}" class="product-link">
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
        </button>`;
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
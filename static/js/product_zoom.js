console.log("product_zoom.js loaded ✔"); // Debug print

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM fully loaded ✔");

    const zoomModal = document.getElementById("zoomModal");
    const zoomImage = document.getElementById("zoomImage");
    const zoomClose = document.getElementById("zoomClose");
    const productImages = document.querySelectorAll(".product-card img");

    // Debug checks
    console.log({
        zoomModal,
        zoomImage,
        zoomClose,
        productImagesCount: productImages.length
    });

    if (!zoomModal || !zoomImage || !zoomClose) {
        console.error("❌ Zoom Modal elements not found. Check IDs.");
        return;
    }

    // Open modal when clicking a product image
    productImages.forEach(img => {
        img.addEventListener("click", () => {
            console.log("Image clicked:", img.src);
            zoomImage.src = img.src;
            zoomModal.style.display = "flex"; // important
        });
    });

    // Close when clicking the X
    zoomClose.addEventListener("click", () => {
        zoomModal.style.display = "none";
    });

    // Close when clicking outside the image
    zoomModal.addEventListener("click", (e) => {
        if (e.target.id === "zoomModal") {
            zoomModal.style.display = "none";
        }
    });
});

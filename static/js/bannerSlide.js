document.addEventListener("DOMContentLoaded", () => {
    const images = document.querySelectorAll(".rotation-image");
    if (images.length === 0) return; // prevents errors on other pages

    let currentIndex = 0;

    function rotateBanner() {
        images[currentIndex].classList.remove("active");
        currentIndex = (currentIndex + 1) % images.length;
        images[currentIndex].classList.add("active");
    }

    setInterval(rotateBanner, 3000);
});

// Run when page loads
document.addEventListener("DOMContentLoaded", function() {

    // Get images, dots, and arrows
    const images = document.querySelectorAll(".rotation-image");
    const indicators = document.querySelectorAll(".banner-indicator");
    const prevBtn = document.querySelector(".banner-prev");
    const nextBtn = document.querySelector(".banner-next");

    // Stop if no images
    if (images.length === 0) return;

    let currentIndex = 0;
    let autoPlayInterval;

    // Show selected slide
    function showSlide(index) {
        images[currentIndex].classList.remove("active");
        indicators[currentIndex].classList.remove("active");

        currentIndex = index;

        images[currentIndex].classList.add("active");
        indicators[currentIndex].classList.add("active");
    }

    // Next image
    function nextSlide() {
        showSlide((currentIndex + 1) % images.length);
    }

    // Previous image
    function prevSlide() {
        showSlide((currentIndex - 1 + images.length) % images.length);
    }

    // Start auto slide
    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 4000);
    }

    // Stop auto slide
    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    // Prev button
    if (prevBtn) {
        prevBtn.addEventListener("click", function() {
            stopAutoPlay();
            prevSlide();
            startAutoPlay();
        });
    }

    // Next button
    if (nextBtn) {
        nextBtn.addEventListener("click", function() {
            stopAutoPlay();
            nextSlide();
            startAutoPlay();
        });
    }

    // Dots click
    indicators.forEach(function(indicator, index) {
        indicator.addEventListener("click", function() {
            stopAutoPlay();
            showSlide(index);
            startAutoPlay();
        });
    });

    // Pause on hover
    const banner = document.querySelector(".banner");
    if (banner) {
        banner.addEventListener("mouseenter", stopAutoPlay);
        banner.addEventListener("mouseleave", startAutoPlay);
    }

    // Start slider
    startAutoPlay();
});

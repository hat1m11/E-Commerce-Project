document.addEventListener("DOMContentLoaded", function() {

    const images = document.querySelectorAll(".rotation-image");
    const indicators = document.querySelectorAll(".banner-indicator");
    const prevBtn = document.querySelector(".banner-prev");
    const nextBtn = document.querySelector(".banner-next");

    if (images.length === 0) return;

    let currentIndex = 0;
    let autoPlayInterval;

    function showSlide(index) {
        images[currentIndex].classList.remove("active");
        indicators[currentIndex].classList.remove("active");

        currentIndex = index;

        images[currentIndex].classList.add("active");
        indicators[currentIndex].classList.add("active");
    }

    function nextSlide() {
        showSlide((currentIndex + 1) % images.length);
    }

    function prevSlide() {
        showSlide((currentIndex - 1 + images.length) % images.length);
    }

    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 4000);
    }

    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    if (prevBtn) {
        prevBtn.addEventListener("click", function() {
            stopAutoPlay();
            prevSlide();
            startAutoPlay();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener("click", function() {
            stopAutoPlay();
            nextSlide();
            startAutoPlay();
        });
    }

    indicators.forEach(function(indicator, index) {
        indicator.addEventListener("click", function() {
            stopAutoPlay();
            showSlide(index);
            startAutoPlay();
        });
    });

    const banner = document.querySelector(".banner");
    if (banner) {
        banner.addEventListener("mouseenter", stopAutoPlay);
        banner.addEventListener("mouseleave", startAutoPlay);
    }

    startAutoPlay();
});
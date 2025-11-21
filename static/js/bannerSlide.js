// Wait for page to fully load
document.addEventListener("DOMContentLoaded", function() {
    // Get all banner images and indicator dots
    const images = document.querySelectorAll(".rotation-image");
    const indicators = document.querySelectorAll(".banner-indicator");
    const prevBtn = document.querySelector(".banner-prev");
    const nextBtn = document.querySelector(".banner-next");
    
    // Exit if no images found (prevents errors on other pages)
    if (images.length === 0) return;

    let currentIndex = 0;
    let autoPlayInterval;

    // Function to show a specific slide
    function showSlide(index) {
        // Remove active class from current image and indicator
        images[currentIndex].classList.remove("active");
        indicators[currentIndex].classList.remove("active");

        // Update index and add active class to new image and indicator
        currentIndex = index;
        images[currentIndex].classList.add("active");
        indicators[currentIndex].classList.add("active");
    }

    // Function to go to next slide
    function nextSlide() {
        let nextIndex = (currentIndex + 1) % images.length;
        showSlide(nextIndex);
    }

    // Function to go to previous slide
    function prevSlide() {
        let prevIndex = (currentIndex - 1 + images.length) % images.length;
        showSlide(prevIndex);
    }

    // Function to start auto-play
    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 4000);
    }

    // Function to stop auto-play
    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    // Add click event to previous button
    if (prevBtn) {
        prevBtn.addEventListener("click", function() {
            stopAutoPlay();
            prevSlide();
            startAutoPlay();
        });
    }

    // Add click event to next button
    if (nextBtn) {
        nextBtn.addEventListener("click", function() {
            stopAutoPlay();
            nextSlide();
            startAutoPlay();
        });
    }

    // Add click events to indicator dots
    indicators.forEach(function(indicator, index) {
        indicator.addEventListener("click", function() {
            stopAutoPlay();
            showSlide(index);
            startAutoPlay();
        });
    });

    // Pause auto-play when hovering over banner
    const banner = document.querySelector(".banner");
    if (banner) {
        banner.addEventListener("mouseenter", stopAutoPlay);
        banner.addEventListener("mouseleave", startAutoPlay);
    }

    // Start the auto-play
    startAutoPlay();
});
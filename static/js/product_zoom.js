document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("zoomModal");
    const zoomImg = document.getElementById("zoomImage");
    const closeBtn = document.querySelector(".close-zoom");

    document.querySelectorAll(".zoom-trigger").forEach(img => {
        img.addEventListener("click", () => {
            zoomImg.src = img.dataset.full;
            modal.style.display = "flex";
        });
    });

    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    modal.addEventListener("click", e => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});

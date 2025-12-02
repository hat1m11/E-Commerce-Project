// Select elements
const modal = document.getElementById("zoomModal");
const modalImg = document.getElementById("zoomImage");
const mainImg = document.getElementById("main-product-image");
const closeBtn = document.querySelector(".zoom-close");

// Open fullscreen zoom modal
mainImg.onclick = function () {
    modal.style.display = "block";
    modalImg.src = this.src;
};

// Close by X button
closeBtn.onclick = function () {
    modal.style.display = "none";
};

// Close by clicking outside the image
modal.onclick = function (event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};

document.querySelectorAll('.product-card img').forEach(img => {
    img.addEventListener('click', () => {
        document.getElementById('zoomImage').src = img.src;
        document.getElementById('zoomModal').style.display = 'flex';
    });
});

document.getElementById('zoomClose').addEventListener('click', () => {
    document.getElementById('zoomModal').style.display = 'none';
});

document.getElementById('zoomModal').addEventListener('click', (e) => {
    if (e.target.id === 'zoomModal') {
        document.getElementById('zoomModal').style.display = 'none';
    }
});
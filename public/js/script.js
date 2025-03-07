let currentIndex = 0;
const carousel = document.querySelector('.carousel');
function nextSlide() {
    currentIndex = (currentIndex + 1) % 3;
    carousel.style.transform = `translateX(-${currentIndex * 100}vw)`;
}
setInterval(nextSlide, 3000);

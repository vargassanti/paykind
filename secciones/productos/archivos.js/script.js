document.addEventListener("DOMContentLoaded", function () {
    const slides = document.querySelectorAll(".carousel-slide");
    let currentSlide = 0;

    function showSlide(index) {
        if (index < 0) {
            currentSlide = slides.length - 1;
        } else if (index >= slides.length) {
            currentSlide = 0;
        }

        slides.forEach((slide, i) => {
            if (i === currentSlide) {
                slide.style.display = "block";
            } else {
                slide.style.display = "none";
            }
        });
    }

    function nextSlide() {
        currentSlide++;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide--;
        showSlide(currentSlide);
    }

    showSlide(currentSlide);

    const nextButton = document.getElementById("nextBtn");
    const prevButton = document.getElementById("prevBtn");

    nextButton.addEventListener("click", nextSlide);
    prevButton.addEventListener("click", prevSlide);

    // Autoplay
    setInterval(nextSlide, 3000); // Cambia la imagen cada 3 segundos
});

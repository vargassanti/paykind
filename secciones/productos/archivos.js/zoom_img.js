let slideIndex = 1;
const modal = document.getElementById("myModal");
const body = document.querySelector("body");

function openModal() {
    modal.style.display = "block";
    body.classList.add("modal-open"); // Agregar clase para bloquear el desplazamiento
    showSlides(slideIndex); // Mostrar la primera imagen al abrir el modal
}

function closeModal() {
    modal.style.display = "none";
    body.classList.remove("modal-open"); // Eliminar clase para permitir el desplazamiento
}

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    const slides = document.getElementsByClassName("product-small-img")[0].getElementsByTagName("img");
    const modalImage = document.getElementById("modalImage");

    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }

    modalImage.src = slides[slideIndex - 1].src;
}

// Evento de escucha para cerrar el modal al hacer clic fuera de él
window.addEventListener("click", function (event) {
    if (event.target === modal) {
        closeModal();
    }
});
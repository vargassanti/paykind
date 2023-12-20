// Obtén todos los elementos con la clase "title-description", "title-additional-information", "title-metodo-pago" y "title-reviews"
const descriptionTitle = document.querySelector(".title-description");
const additionalInformationTitle = document.querySelector(".title-additional-information");
const metodoPagoTitle = document.querySelector(".title-metodo-pago");
const reviewsTitle = document.querySelector(".title-reviews");

// Agrega un evento de clic a cada uno de los elementos del título
descriptionTitle.addEventListener("click", toggleDescription);
additionalInformationTitle.addEventListener("click", toggleAdditionalInformation);
metodoPagoTitle.addEventListener("click", toggleMetodoPago);
reviewsTitle.addEventListener("click", toggleReviews);

function toggleDescription() {
  const textDescription = document.querySelector(".text-description");
  textDescription.classList.toggle("hidden");
}

function toggleAdditionalInformation() {
  const textAdditionalInformation = document.querySelector(".text-additional-information");
  textAdditionalInformation.classList.toggle("hidden");
}

function toggleMetodoPago() {
  const textMetodoPago = document.querySelector(".text-metodo-pago");
  textMetodoPago.classList.toggle("hidden");
}

function toggleReviews() {
  const textReviews = document.querySelector(".text-reviews");
  textReviews.classList.toggle("hidden");
}

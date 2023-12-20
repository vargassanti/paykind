// Obtiene todas las preguntas
const questions = document.querySelectorAll('.question');

// Itera sobre cada pregunta y agrega un evento de clic para mostrar la respuesta
questions.forEach(question => {
  question.addEventListener('click', () => {
    const arrow = question.querySelector('.arrowP');
    const answer = question.nextElementSibling;

    // Si la respuesta está oculta, la muestra; de lo contrario, la oculta
    if (answer.style.display === 'none' || answer.style.display === '') {
      answer.style.display = 'block';
      arrow.classList.add('opened');
    } else {
      answer.style.display = 'none';
      arrow.classList.remove('opened');
    }
  });
});

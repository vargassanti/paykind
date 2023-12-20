<footer>
  <div class="container__footer">
    <div class="contact-info">
      <h2>CONTACTO</h2>
      <p><i class="fab fa-whatsapp"></i></p>
      <p><i class="fab fa-facebook-square"></i></p>
      <p><i class="fab fa-instagram-square"></i></p>
    </div>
    <div class="about-us">
      <h2>QUIÉNES SOMOS</h2>
      <ul>
        <li>Cultura</li>
        <li>Trabaja aquí</li>
        <li>La vida en Mattelsa</li>
      </ul>
    </div>
    <div class="help">
      <h2>AYUDA</h2>
      <ul>
        <li>Envíos</li>
        <li>Cambios y garantías</li>
        <li>Preguntas frecuentes</li>
      </ul>
    </div>
  </div>
  <hr>
  <div class="follow-us">
    <p>
      <a href="#">Términos y condiciones</a> |
      <a href="#">Política de Privacidad</a> |
      <a href="#">Cómo cuidamos tu privacidad</a>
    </p>
  </div>
</footer>
</body>

<style>
  body {
    scrollbar-width: none;
    /* Firefox */
    -ms-overflow-style: none;
    /* Internet Explorer y Edge */
  }

  /* Agrega un estilo personalizado al scroll (opcional) */
  body::-webkit-scrollbar {
    width: 0px;
  }

  /* Estilos para el cuerpo */
  body {
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }


  footer {
    width: 100%;
    padding: 50px 0px;
    background-image: url(../imagen/background-footer.svg);
    background-size: cover;

    /*background-color: #d0f0f8;
    -webkit-mask-image: url("../Images/background-footer.svg");
    mask-image: url("../Images/background-footer.svg");
    -webkit-mask-size: cover;
    mask-size: cover;*/
  }

  .container__footer {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    max-width: 1200px;
    margin: auto;
    margin-top: 100px;
  }

  .box__footer {
    display: flex;
    flex-direction: column;
    padding: 40px;
  }

  .box__footer .logo img {
    width: 156px;
  }

  .box__footer .terms {
    max-width: 350px;
    margin-top: 20px;
    font-weight: 500;
    color: #7a7a7a;
    font-size: 18px;
  }

  .box__footer h2 {
    margin-bottom: 30px;
    color: #343434;
    font-weight: 700;
  }

  .box__footer a {
    margin-top: 10px;
    color: #7a7a7a;
    font-weight: 600;
    width: 110px;
  }

  .box__footer a:hover {
    opacity: 0.8;
  }

  .box__footer a .fab {
    font-size: 20px;
  }

  .box__copyright {
    max-width: 1200px;
    margin: auto;
    text-align: center;
    padding: 0px 40px;
  }

  .box__copyright p {
    margin-top: 20px;
    color: #7a7a7a;
  }

  .box__copyright hr {
    border: none;
    height: 1px;
    background-color: #7a7a7a;
  }

  /* ESTILOS INDEX */

  .swiper-hero {
    width: 100%;
    max-width: 1400px;
    position: relative;
    left: 63px;
    top: 10px;
  }

  .swiper-hero .swiper-slide {
    width: 250px;
  }

  .swiper-hero img {
    height: 255px;
    width: 130%;
    object-fit: cover;
  }
</style>


</html>
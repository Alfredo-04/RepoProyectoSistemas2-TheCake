<?php
include 'templates/header.php';
?>
      <!-- Swiper-->
      <section class="section swiper-container swiper-slider swiper-slider-2 swiper-slider-3" data-loop="true" data-autoplay="5000" data-simulate-touch="false" data-slide-effect="fade">
        <div class="swiper-wrapper text-sm-left">
          <div class="swiper-slide context-dark" data-slide-bg="../public/assets/CAKE/6.png">
            <div class="swiper-slide-caption section-md">
              <div class="container">
                <div class="row">
                  <div class="col-sm-9 col-md-8 col-lg-7 col-xl-7 offset-lg-1 offset-xxl-0">
                    <h1 class="oh swiper-title"><span class="d-inline-block" data-caption-animate="slideInUp" data-caption-delay="0">MOMENTOS INOLVIDABLES</span></h1>
                    <p class="big swiper-text" data-caption-animate="fadeInLeft" data-caption-delay="300">Visitanos con amigos o con esa persona especial para llevar en tu corazon los mejores recuerdos</p><a class="button button-lg button-primary button-winona button-shadow-2" href="#" data-caption-animate="fadeInUp" data-caption-delay="300">Nuestro menu</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide context-dark" data-slide-bg="../public/assets/CAKE/1.png">
            <div class="swiper-slide-caption section-md">
              <div class="container">
                <div class="row">
                  <div class="col-sm-8 col-lg-7 offset-lg-1 offset-xxl-0">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Swiper Pagination-->
        <div class="swiper-pagination" data-bullet-custom="true"></div>
        <!-- Swiper Navigation-->
        <div class="swiper-button-prev">
          <div class="preview">
            <div class="preview__img"></div>
          </div>
          <div class="swiper-button-arrow"></div>
        </div>
        <div class="swiper-button-next">
          <div class="swiper-button-arrow"></div>
          <div class="preview">
            <div class="preview__img"></div>
          </div>
        </div>
      </section>
    <!--MAPA-->
    

<!-- Contacts-->
<section class="section section-lg bg-default text-md-left">
  <div class="container">
    <div class="row row-60 justify-content-center">
      <div class="col-lg-8">
        <h4 class="text-spacing-25 text-transform-none">Manda comentarios</h4>
        <form class="rd-form rd-mailform" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php">
          <div class="row row-20 gutters-20">
            <div class="col-md-6">
              <div class="form-wrap">
                <input class="form-input" id="contact-your-name-5" type="text" name="name" data-constraints="@Required">
                <label class="form-label" for="contact-your-name-5">Tu nombre*</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-wrap">
                <input class="form-input" id="contact-email-5" type="email" name="email" data-constraints="@Email @Required">
                <label class="form-label" for="contact-email-5">Tu E-mail*</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-wrap">
                <!--Select 2-->
                <select class="form-input" data-minimum-results-for-search="Infinity" data-constraints="@Required">
                  <option value="1">Calificanos</option>
                  <option value="2">Malo</option>
                  <option value="3">Regular</option>
                  <option value="4">Excelente</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-wrap">
                <input class="form-input" id="contact-phone-5" type="text" name="phone" data-constraints="@Numeric">
                <label class="form-label" for="contact-phone-5">Tu numero de celular*</label>
              </div>
            </div>
            <div class="col-12">
              <div class="form-wrap">
                <label class="form-label" for="contact-message-5">Comentarios</label>
                <textarea class="form-input textarea-lg" id="contact-message-5" name="message" data-constraints="@Required"></textarea>
              </div>
            </div>
          </div>
          <button class="button button-secondary button-winona" type="submit">THE CAKE</button>
        </form>
      </div>
      
    </div>
  </div>
</section>

<?php

include 'templates/footer.php';
?>  












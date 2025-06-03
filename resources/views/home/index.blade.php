@extends('layouts.app')

@section('title', 'The Cake - Inicio')

@section('content')
<!-- Swiper-->
<section class="section swiper-container swiper-slider swiper-slider-2 swiper-slider-3" data-loop="true" data-autoplay="5000" data-simulate-touch="false" data-slide-effect="fade">
    <div class="swiper-wrapper text-sm-left">
        <div class="swiper-slide context-dark" data-slide-bg="{{ asset('assets/CAKE/6.png') }}">
            <div class="swiper-slide-caption section-md">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9 col-md-8 col-lg-7 col-xl-7 offset-lg-1 offset-xxl-0">
                            <h1 class="oh swiper-title"><span class="d-inline-block" data-caption-animate="slideInUp" data-caption-delay="0">MOMENTOS INOLVIDABLES</span></h1>
                            <p class="big swiper-text" data-caption-animate="fadeInLeft" data-caption-delay="300">Visitanos con amigos o con esa persona especial para llevar en tu corazon los mejores recuerdos</p>
                            <a class="button button-lg button-primary button-winona button-shadow-2" href="{{ route('menu') }}" data-caption-animate="fadeInUp" data-caption-delay="300">Nuestro menu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-slide context-dark" data-slide-bg="{{ asset('assets/CAKE/1.png') }}">
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
<section>
    <div class="row w-100">
        <div class="col-lg-6 my-4">
            <img src="{{ asset('assets/CAKE/2.png') }}" alt="">
        </div>
        <div class="col-lg-6 my-4 d-flex align-items-center">
            <div>
                <h3 class="mb-4">SOMOS THE CAKE!!!</h3>
                <p class="lead"><strong>The Cake</strong> - Maravillosos recuerdos que lleva tu paladar</p>
                
                <p class="mt-4">En The Cake nos preocupamos por tu estancia en nuestro local ya que preparamos todos nuestros productos con amor y cariño para que te lleves una experiencia inolvidable y puedas volver, solo, con tu familia, con tus amigos y/o con tu persona favorita.
                Nos encontramos en la Zona Sur de La Paz y en el centro de Tarija.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- QUE DICE LA GENTE-->
<section class="section section-xl bg-default">
    <div class="container">
        <h3 class="wow fadeInLeft">¿QUÉ DICE LA GENTE DE NOSOTROS?</h3>
    </div>
    <div class="container container-style-1">
        <div class="owl-carousel owl-style-12" data-items="1" data-sm-items="2" data-lg-items="3" data-margin="30" data-xl-margin="45" data-autoplay="true" data-nav="true" data-center="true" data-smart-speed="400">
            <!-- Quote Tara-->
            <article class="quote-tara">
                <div class="quote-tara-caption">
                    <div class="quote-tara-text">
                        <p class="q">The Cake es la cafetería con más tradición en la ciudad y está excelentemente gestionada. Los precios son geniales y me permiten seguir viniendo cada semana.</p>
                    </div>
                    <div class="quote-tara-figure"><img src="{{ asset('assets/CAKE/persona.jpg') }}" alt="" width="115" height="115"/>
                    </div>
                </div>
                <h6 class="quote-tara-author">Leandro Bolaños</h6>
                <div class="quote-tara-status">Cliente</div>
            </article>
            <!-- Quote Tara-->
            <article class="quote-tara">
                <div class="quote-tara-caption">
                    <div class="quote-tara-text">
                        <p class="q">Soy un auténtico adicto a los postres, y aunque esté en casa prefiero los pasteles de The Cake antes que cualquier otro. Son deliciosos y tienen un precio muy razonable.</p>
                    </div>
                    <div class="quote-tara-figure"><img src="{{ asset('assets/CAKE/persona.jpg') }}" alt="" width="115" height="115"/>
                    </div>
                </div>
                <h6 class="quote-tara-author">Daniel Mendiola</h6>
                <div class="quote-tara-status">Cliente</div>
            </article>
            <!-- Quote Tara-->
            <article class="quote-tara">
                <div class="quote-tara-caption">
                    <div class="quote-tara-text">
                        <p class="q">The Cake tiene unos pasteles increíbles. No solo te atienden con una gran sonrisa, sino que además disfrutas de postres exquisitos a un precio excelente.</p>
                    </div>
                    <div class="quote-tara-figure"><img src="{{ asset('assets/CAKE/persona.jpg') }}" alt="" width="115" height="115"/>
                    </div>
                </div>
                <h6 class="quote-tara-author">Alfredo Cortez</h6>
                <div class="quote-tara-status">Cliente</div>
            </article>
        </div>
    </div>
</section>

<!-- Section Services  Last section-->
<section class="section section-sm bg-default">
    <div class="container">
        <div class="owl-carousel owl-style-11 dots-style-2" data-items="1" data-sm-items="1" data-lg-items="2" data-xl-items="4" data-margin="30" data-dots="true" data-mouse-drag="true" data-rtl="true">
            <article class="box-icon-megan wow fadeInUp">
                <div class="box-icon-megan-header">
                    <div class="box-icon-megan-icon linearicons-bag"></div>
                </div>
                <h5 class="box-icon-megan-title"><a href="#">Misión</a></h5>
                <p class="box-icon-megan-text">Endulzar momentos especiales con creatividad y calidad, ofreciendo pasteles artesanales hechos con ingredientes frescos y amor boliviano.</p>
            </article>
            <article class="box-icon-megan wow fadeInUp" data-wow-delay=".05s">
                <div class="box-icon-megan-header">
                    <div class="box-icon-megan-icon linearicons-map2"></div>
                </div>
                <h5 class="box-icon-megan-title"><a href="#">Visión</a></h5>
                <p class="box-icon-megan-text">Ser la pastelería líder en Bolivia, reconocida por innovar en sabores tradicionales y convertir cada celebración en una experiencia memorable.</p>
            </article>
            <article class="box-icon-megan wow fadeInUp" data-wow-delay=".1s">
                <div class="box-icon-megan-header">
                    <div class="box-icon-megan-icon linearicons-radar"></div>
                </div>
                <h5 class="box-icon-megan-title"><a href="#">Objetivo</a></h5>
                <p class="box-icon-megan-text">Superar expectativas con diseños personalizados, atención cálida y compromiso con la satisfacción total de nuestros clientes.</p>
            </article>
            <article class="box-icon-megan wow fadeInUp" data-wow-delay=".15s">
                <div class="box-icon-megan-header">
                    <div class="box-icon-megan-icon linearicons-thumbs-up"></div>
                </div>
                <h5 class="box-icon-megan-title"><a href="#">Filosofía</a></h5>
                <p class="box-icon-megan-text">Creemos que cada pastel cuenta una historia. Combinamos tradición, innovación y pasión por la repostería en cada creación.</p>
            </article>
        </div>
    </div>
</section>
@endsection

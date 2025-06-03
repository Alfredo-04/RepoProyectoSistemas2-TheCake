@extends('layouts.app')

@section('title', 'The Cake - Sucursales')

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
        <div class="col-lg-6 my-4 d-flex align-items-center">
            <div>
                <h3 class="mb-4">Visítanos en San miguel</h3>
                <p class="lead"><strong>The Cake</strong> - Dulces momentos en cada bocado</p>
                
                <p><i class="fas fa-map-marker-alt me-2"></i> <strong>Ubicación:</strong> Av. Gabriel René Moreno, Zona Sur, La Paz</p>
                
                <p><i class="fas fa-clock me-2"></i> <strong>Horario de atención:</strong><br>
                Lunes a Viernes: 8:30 - 22:00<br>
                Sábados y Domingos: 9:30 - 20:00</p>
                
                <p><i class="fas fa-phone me-2"></i> <strong>Reservas y pedidos:</strong> +591 75424853</p>
                
                <p class="mt-4">En The Cake nos especializamos en crear experiencias dulces e inolvidables. Nuestra pastelería artesanal combina tradición e innovación para ofrecerte los mejores postres de Bolivia.</p>
                
                <p>¡Te esperamos para disfrutar de nuestro delicioso menú en un ambiente acogedor!</p>
            </div>
        </div>
        <div class="col-lg-6 my-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3824.6819185183003!2d-68.08126762605482!3d-16.542148341809437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915f21044fa3d5ef%3A0x397f76d4267ff4c2!2sThe%20Cake!5e0!3m2!1ses!2sbo!4v1743036621682!5m2!1ses!2sbo" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<section>
    <div class="row w-100">
        <div class="col-lg-6 my-4 d-flex align-items-center">
            <div>
                <h3 class="mb-4">Visítanos en Tarija</h3>
                <p class="lead"><strong>The Cake</strong> - Dulces momentos en cada paso</p>
                
                <p><i class="fas fa-map-marker-alt me-2"></i> <strong>Ubicación:</strong> Av. Colon Entre calles La madrid e ingavi, Tarija</p>
                
                <p><i class="fas fa-clock me-2"></i> <strong>Horario de atención:</strong><br>
                Lunes a Viernes: 8:30 - 21:00<br>
                Sábados y Domingos: 9:00 - 21:00</p>
                
                <p><i class="fas fa-phone me-2"></i> <strong>Reservas y pedidos:</strong> +591 75424853</p>
                
                <p class="mt-4">En The Cake nos especializamos en crear experiencias dulces e inolvidables. Nuestra pastelería artesanal combina tradición e innovación para ofrecerte los mejores postres de Bolivia.</p>
                
                <p>¡Te esperamos para disfrutar de nuestro delicioso menú en un ambiente acogedor!</p>
            </div>
        </div>
        <div class="col-lg-6 my-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3711.3290119431754!2d-64.73450052587276!3d-21.533986790253046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x940647ac0e66bb7d%3A0xecd6083e86f7024d!2sThe%20Cake!5e0!3m2!1ses!2sbo!4v1743039376803!5m2!1ses!2sbo" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>
@endsection
<!-- Page Header-->
<header class="section page-header">
  <!-- RD Navbar-->
  <div class="rd-navbar-wrap">
    <nav class="rd-navbar rd-navbar-modern" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="56px" data-xl-stick-up-offset="56px" data-xxl-stick-up-offset="56px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
      <div class="rd-navbar-inner-outer">
        <div class="rd-navbar-inner">
          <!-- RD Navbar Panel-->
          <div class="rd-navbar-panel">
            <!-- RD Navbar Toggle-->
            <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
            <!-- RD Navbar Brand-->
            <div class="rd-navbar-brand"><a class="brand" href="{{ route('home') }}"><img class="brand-logo-dark" src="{{ asset('assets/images/logoTheCake.png') }}" alt="" width="198" height="66"/></a></div>
          </div>
          <div class="rd-navbar-right rd-navbar-nav-wrap">
            <div class="rd-navbar-aside">
              <ul class="rd-navbar-contacts-2">
                <li>
                  <div class="unit unit-spacing-xs">
                    <div class="unit-left"><span class="icon mdi mdi-phone"></span></div>
                    <div class="unit-body"><a class="phone" href="tel:#">+591 75424853</a></div>
                  </div>
                </li>
                <li>
                  <div class="unit unit-spacing-xs">
                    <div class="unit-left"><span class="icon mdi mdi-map-marker"></span></div>
                    <div class="unit-body"><a class="address" href="#">Gabriel Rene Moreno, La Paz, Bolivia</a></div>
                  </div>
                </li>
              </ul>
              <ul class="list-share-2">
                <li><a class="icon mdi mdi-facebook" href="https://www.facebook.com/TheCake.bo/?locale=es_LA" target="_blank"></a></li>
                <li><a class="icon mdi mdi-instagram" href="https://www.instagram.com/thecake.bolivia/?hl=es" target="_blank"></a></li>
              </ul>
            </div>
            <div class="rd-navbar-main">
              <ul class="rd-navbar-nav" style="display: flex; align-items: center; width: 100%;">
                <li class="rd-nav-item {{ request()->routeIs('home') ? 'active' : '' }}"><a class="rd-nav-link" href="{{ route('home') }}">THE CAKE</a></li>
                <li class="rd-nav-item {{ request()->routeIs('menu') ? 'active' : '' }}"><a class="rd-nav-link" href="{{ route('menu') }}">MENU</a></li>
                <li class="rd-nav-item {{ request()->routeIs('branches') ? 'active' : '' }}"><a class="rd-nav-link" href="{{ route('branches') }}">SUCURSALES</a></li>
                <li class="rd-nav-item {{ request()->routeIs('contact') ? 'active' : '' }}"><a class="rd-nav-link" href="{{ route('contact') }}">CONTACTANOS</a></li>
                
                @auth
                  <!-- Menú desplegable del usuario -->
                  <li class="rd-nav-item dropdown ml-auto">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle rd-nav-link" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="color: #ff6f61;">
                      <i class="fas fa-user-circle fs-3 me-1" style="color: #ff6f61; font-size: 2rem;"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser" style="background: rgba(255, 255, 255, 0.98); border-radius: 15px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); border: none; padding: 10px 0;">
                      <li>
                        <div class="dropdown-item" style="font-family: 'Poppins', sans-serif; color: #ff6f61; font-weight: 600; padding: 8px 20px;">
                          <strong>{{ auth()->user()->nombre }}</strong>
                        </div>
                      </li>
                      <li>
                        <div class="dropdown-item" style="font-family: 'Poppins', sans-serif; color: #333; padding: 8px 20px;">
                          ROL: {{ auth()->user()->rol->nombre_rol }}
                        </div>
                      </li>
                      <li><hr class="dropdown-divider" style="margin: 0.5rem 20px;"></li>
                      
                      @if(auth()->user()->rol_id != 5) {{-- Mostrar Paneles solo si no es cliente --}}
                      <li>
                        <a class="dropdown-item" href="{{ route('dashboard') }}" style="font-family: 'Poppins', sans-serif; color: #333; transition: all 0.3s; padding: 8px 20px;">
                          <i class="fas fa-tachometer-alt me-2" style="color: #ff6f61;"></i>Paneles
                        </a>
                      </li>
                      @endif
                      
                      <li>
                        <a class="dropdown-item" href="#" style="font-family: 'Poppins', sans-serif; color: #333; transition: all 0.3s; padding: 8px 20px;">
                          <i class="fas fa-user-circle me-2" style="color: #ff6f61;"></i>Ver cuenta
                        </a>
                      </li>
                      <li>
                        <form action="{{ route('logout') }}" method="POST">
                          @csrf
                          <button type="submit"
                            class="dropdown-item"
                            style="font-family: 'Poppins', sans-serif; color: #333; transition: all 0.3s; background: none; border: none; width: 100%; text-align: left; padding: 8px 20px; cursor: pointer;"
                            onmouseover="this.style.backgroundColor='#f8f9fa'; this.style.color='#ff6f61';"
                            onmouseout="this.style.backgroundColor=''; this.style.color='#333';"
                          >
                            <i class="fas fa-sign-out-alt me-2" style="color: #ff6f61;"></i>Cerrar sesión
                          </button>
                        </form>
                      </li>
                    </ul>
                  </li>
                @else
                  <!-- Botón de iniciar sesión si no hay sesión activa -->
                  <li class="rd-nav-item">
                      <a href='/login-signup' class="rd-nav-link">INICIAR SESION</a>
                    </a>
                  </li>
                @endauth
              </ul>
            </div>
            @if(request()->routeIs('menu'))
                <!-- Ícono del carrito -->
                <a href="{{ route('pedido') }}" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            @endif
          </div>
        </div>
      </div>
    </nav>
  </div>
</header>
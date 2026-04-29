<nav class="navbar navbar-expand-lg bg-white sticky-top dh-navbar">
    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('home') }}"
           style="letter-spacing: 3px; font-size: 1.1rem; color: var(--dh-text); font-family: 'DM Sans', sans-serif;">
            DOUBLE <span style="color: #D4006A;">HELIX</span>
        </a>

        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarMain"
                aria-controls="navbarMain" aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">

            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link dh-nav-link px-2" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link dh-nav-link px-2" href="#">Mujer</a> {{-- route pendiente --}}
                </li>
                <li class="nav-item">
                    <a class="nav-link dh-nav-link px-2" href="#">Hombre</a> {{-- route pendiente --}}
                </li>
                <li class="nav-item">
                    <a class="nav-link dh-nav-link px-2" href="{{ route('products.index') }}">Colecciones</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link dh-nav-link px-2" href="#">Ofertas</a> {{-- route pendiente --}}
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">

                <a href="{{ route('cart.index') }}" class="position-relative text-decoration-none"
                   style="color: var(--dh-text);" aria-label="Carrito">
                    <i class="bi bi-bag" style="font-size: 1.2rem;"></i>
                    @php $cartCount = session('cart') ? count(session('cart')) : 0; @endphp
                    @if ($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                              style="background-color: #D4006A; font-size: 0.6rem;">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-dh-outline btn-sm px-3" style="font-size: 0.82rem;">Login</a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-dh btn-sm px-3" style="font-size: 0.82rem;">Registro</a>
                    @endif
                @endguest

                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none" {{-- route pendiente: admin.index --}}
                           style="color: #D4006A; font-size: 0.82rem; font-weight: 600; letter-spacing: 0.5px;">
                            <i class="bi bi-shield-lock me-1"></i>Admin
                        </a>
                    @endif

                    <div class="dropdown">
                        <button class="btn btn-dh-outline btn-sm px-3 dropdown-toggle"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                style="font-size: 0.82rem;">
                            <i class="bi bi-person me-1"></i>Mi cuenta
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end border-0 mt-2"
                            style="box-shadow: 0 8px 24px rgba(0,0,0,0.08); border-radius: 2px; min-width: 200px;">
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.orders') }}"
                                   style="font-size: 0.85rem; color: var(--dh-text);">
                                    <i class="bi bi-box-seam me-2" style="color: #D4006A;"></i>Mis pedidos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.addresses') }}"
                                   style="font-size: 0.85rem; color: var(--dh-text);">
                                    <i class="bi bi-geo-alt me-2" style="color: #D4006A;"></i>Mi perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1" style="border-color: #F0F0F0;"></li>
                            @if (Route::has('logout'))
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2"
                                                style="font-size: 0.85rem; color: #dc2626;">
                                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endauth

            </div>
        </div>
    </div>
</nav>

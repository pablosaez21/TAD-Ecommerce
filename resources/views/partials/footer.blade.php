<footer class="dh-footer">
    <div class="container py-5">

        <div class="mb-5">
            <p style="letter-spacing: 3px; font-size: 1.1rem; font-weight: 700; color: #fff; margin-bottom: 4px; font-family: 'DM Sans', sans-serif;">
                DOUBLE <span style="color: #D4006A;">HELIX</span>
            </p>
            <p class="mb-0" style="font-size: 0.85rem; color: #9CA3AF;">Deporte en nuestro ADN.</p>
        </div>

        <div class="row g-4">

            <div class="col-6 col-md-3">
                <h6 style="letter-spacing: 2px; font-size: 0.7rem; text-transform: uppercase; color: #fff; margin-bottom: 16px; font-weight: 600;">
                    Tienda
                </h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" class="dh-footer-link">Inicio</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('products.index') }}" class="dh-footer-link">Categorías</a>
                    </li>
                </ul>
            </div>

            <div class="col-6 col-md-3">
                <h6 style="letter-spacing: 2px; font-size: 0.7rem; text-transform: uppercase; color: #fff; margin-bottom: 16px; font-weight: 600;">
                    Ayuda
                </h6>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="#" class="dh-footer-link">Envíos y devoluciones</a></li>
                    <li class="mb-2"><a href="#" class="dh-footer-link">Guía de tallas</a></li>
                    <li class="mb-2"><a href="#" class="dh-footer-link">Contacto</a></li>
                    <li class="mb-2"><a href="#" class="dh-footer-link">FAQ</a></li>
                </ul>
            </div>

            <div class="col-6 col-md-3">
                <h6 style="letter-spacing: 2px; font-size: 0.7rem; text-transform: uppercase; color: #fff; margin-bottom: 16px; font-weight: 600;">
                    Mi cuenta
                </h6>
                <ul class="list-unstyled mb-0">
                    @auth
                        <li class="mb-2">
                            <a href="{{ route('profile.orders') }}" class="dh-footer-link">Mis pedidos</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('profile.addresses') }}" class="dh-footer-link">Mis direcciones</a>
                        </li>
                    @else
                        @if (Route::has('login'))
                            <li class="mb-2"><a href="{{ route('login') }}" class="dh-footer-link">Iniciar sesión</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li class="mb-2"><a href="{{ route('register') }}" class="dh-footer-link">Crear cuenta</a></li>
                        @endif
                    @endauth
                </ul>
            </div>

            <div class="col-6 col-md-3">
                <h6 style="letter-spacing: 2px; font-size: 0.7rem; text-transform: uppercase; color: #fff; margin-bottom: 16px; font-weight: 600;">
                    Síguenos
                </h6>
                <div class="d-flex gap-3" style="font-size: 1.2rem;">
                    <a href="#" class="dh-footer-link" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="dh-footer-link" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    <a href="#" class="dh-footer-link" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                </div>
            </div>

        </div>

        <hr style="border-color: #2D2D2D; margin-top: 3rem; margin-bottom: 1.5rem;">

        <p class="text-center mb-0" style="font-size: 0.82rem; color: #9CA3AF;">
            &copy; {{ date('Y') }} Double Helix. Todos los derechos reservados.
        </p>

    </div>
</footer>

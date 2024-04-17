<style>
    /* Estilos para el footer */
    .footer_section {
        padding: 40px 15px !important; /* Asegura que el padding se aplique incluso si hay otros estilos */
    }

    .footer-col {
        margin-bottom: 40px !important; /* Aumenta el espacio entre columnas */
    }

    .footer_contact,
    .footer_detail {
        text-align: center !important; /* Asegura que el texto se alinee al centro */
    }

    .footer_social {
        margin-top: 20px !important; /* Asegura que el margen superior se aplique */
    }

    .footer_social a {
        margin-right: 10px !important; /* Asegura que el margen derecho se aplique */
    }

    .mapa {
        text-align: center !important; /* Asegura que el texto se alinee al centro */
    }

    /* Estilos para hacer el footer responsive */
    @media (min-width: 768px) {
        .footer-col {
            margin-bottom: 0 !important; /* Asegura que el margen inferior se establezca a cero en pantallas más grandes */
        }
    }

    @media (min-width: 992px) {
        .footer_contact,
        .footer_detail,
        .footer-col {
            text-align: left !important; /* Asegura que el texto se alinee a la izquierda en pantallas más grandes */
        }

        .footer_social,
        .footer-info {
            text-align: center !important; /* Alinea el texto al centro en pantallas más grandes */
        }

        .mapa {
            text-align: right !important; /* Asegura que el texto se alinee a la derecha en pantallas más grandes */
        }

        .footer-col {
            width: 25% !important; /* Ancho de las columnas */
            padding: 0 10px !important; /* Espacio interno de las columnas */
        }

        /* Ajuste para la columna izquierda */
        .footer-col:first-child {
            margin-left: 0 !important; /* Elimina el margen izquierdo */
        }
    }
</style>

<br><footer class="footer_section">
    <div class="container1">
        <div class="row">
            <!-- Columna 1: Contáctenos -->
            <div class="col-md-3 footer-col">
                <div class="footer_contact">
                    <h4>
                        Contáctenos
                    </h4>
                    <div class="contact_link_box">
                        <a href="">
                            <i class="fa fa-map-marker" aria-hidden="false"></i>
                            <p>
                               Estamos ubicados del Centro Turístico Cascada San Mateo
                        </p>
                        </a>
                        <a href="https://wa.link/lubcuz">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <span>
                                Llamar al +593 99 389 0442
                            </span>
                        </a>
        
                        </a>
                    </div>
                </div>
            </div>
            <!-- Columna 2: Mensaje del sitio -->
            <div class="col-md-3 footer-col">
                <div class="footer_detail">
                    <a href="" class="footer-logo">
                        Centro Turístico San Mateo
                    </a>
                    <p>
                        Nos encanta la naturaleza y estamos comprometidos con su conservación.
                    </p>
                    <div class="footer_social">
                        <a href="https://www.facebook.com/share/zz7vP3gfFmctsKef/?mibextid=qi2Omg">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                        <a href="https://www.instagram.com/cascadassanmateo?igsh=ZDNzcnBnd2RmMWY4">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>

                    </div>
                </div>
            </div>
            <!-- Columna 3: Horario de atención -->
            <div class="col-md-3 footer-col">
                <h4>
                    Horario de Atención
                </h4>
                <p>
                    Todos los días
                </p>
                <p>
                    8:00 A.M - 11:00 P.M
                </p>
            </div>
            <!-- Columna 4: Mapa -->
            <div class="col-md-3 footer-col">
            <h4>
                    Ubicación
                </h4>
                
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.7718677173016!2d-79.2946113!3d-1.3122916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d353ace3931e6d%3A0x1ab8a69cd300410a!2sCascada%20San%20Mateo!5e0!3m2!1ses-419!2sec!4v1710939234923!5m2!1ses-419!2sec" width="300" height="300"  allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <div  class="mapa">

                </div>
            </div>
        </div>
        <!-- Texto de derechos de autor -->
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="footer-info">
                    <p>
                        &copy; <span id="displayYear"></span> Todos los derechos reservados por el
                        <a href="#">Centro Turístico San Mateo</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

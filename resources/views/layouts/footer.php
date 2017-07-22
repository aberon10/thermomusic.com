            <!-- FOOTER -->
            <footer class="footer">
                <?php if ($_SERVER['PHP_SELF'] == '/' ||  $_SERVER['PHP_SELF'] == '/home/index'): ?>
                <!-- advertising -->
                <div class="cover-image  cover-image__small  advertising" id="footer-advertising">
                    <div class="cover-image__message  advertising-message">
                        <h1>La música de estos y muchos otros artistas te esperan, registrate ahora!</h1>
                        <div class="buttons-group">
                            <a href="/home/offers" class="button  button-cyan  button-big">Inciar 60 días de prueba</a>
                            <a href="/profile/demo" class="button  button-black  button-big" id="demo">Probar Demo</a> 
                        </div>
                        <form method="POST" action="/profile/demo" id="form-demo" name="form-demo">
                            <input type="hidden" name="_demo" value="_demo">
                        </form>
                    </div>                    
                </div>
                <?php endif; ?>
                <div class="foooter-header">                    
                    <!-- social networks -->
                    <div class="boxed">     
                        <h2>Síguenos en nuestras redes sociales !</h2>               
                        <div class="buttons-group">
                            <a href="#" class="icon-social  social-button  social-button-big  facebook"><span class="icon-facebook"></span></a>
                            <a href="#" class="icon-social  social-button  social-button-big  twitter"><span class="icon-twitter"></span></a>
                            <a href="#" class="icon-social  social-button  social-button-big  googlemas"><span class="icon-google"></span></a>
                            <a href="#" class="icon-social  social-button  social-button-big  instagram"><span class="icon-instagram"></span></a>
                            <a href="#" class="icon-social  social-button  social-button-big  youtube"><span class="icon-youtube"></span></a>
                        </div>
                    </div>
                </div>
                <div class="footer-body  boxed">
                    <div class="information-contact">
                        <div>
                            <h5>ThermoMusic</h5>
                            <p class="text-left">ThermoMusic es un servicio de música digital que te da acceso a un gran catálogo de canciones y diversos géneros musicales. Podes encontrar la mejor música para cada momento desde el celular, computadora, tablet. </p>
                            <p class="text-left">También puedes crear playlist, guardar tus canciones favoritas entre otros <a href="/home/aboutus">Conocer más</a></p>

                        </div>                        
                        <div>
                            <h5>Enlaces útiles</h5>
                            <p class="text-center"><a href="/home/aboutus">Empresa</a></p>
                            <p class="text-center"><a href="/home/offers">Ofertas</a></p>
                            <p class="text-center"><a href="/home/support">Soporte</a></p>
                            <p class="text-center"><a href="/home/help">Ayuda</a></p>
                        </div>
                        <div>
                            <h5>Contacto</h5>
                            <p class="text-center">Email: thermoteam2016@gmail.com</p>
                            <p class="text-center">Web: www.thermomusic.com</p>   
                        </div>
                    </div>
                    <div class="copyright">
                        <p>&copy 2016 - <?= date('Y') ?> ThermoMusic</p>
                    </div>
                </div>
            </footer>
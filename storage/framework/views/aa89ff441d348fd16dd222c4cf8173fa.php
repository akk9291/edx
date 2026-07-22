<footer class="footer">
    <div class="footer-container">
        <div class="footer-column logo-section">
            <a href="<?php echo e(route('home')); ?>" class="inline-block" aria-label="EDX Rulmenți — Home">
                <img src="<?php echo e(asset('assets/images/EDX-LOGO-RULMENTI.png')); ?>" alt="EDX Rulmenți" width="150" height="150" style="width: 140px; max-width: 100%; height: auto; display: block;">
            </a>
        </div>

        <div class="footer-column">
            <h3>Products & services</h3>
            <ul>
                <li><a href="<?php echo e(route('frontend.range')); ?>">Ball Bearing</a></li>
                <li><a href="<?php echo e(route('frontend.range')); ?>">Spherical Roller Bearing</a></li>
                <li><a href="<?php echo e(route('frontend.range')); ?>">Cylindrical Roller Bearing</a></li>
                <li><a href="<?php echo e(route('frontend.range')); ?>">Taper Roller Bearing</a></li>
                <li><a href="<?php echo e(route('frontend.range')); ?>">Pillow Block</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h3>Get in touch</h3>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <p>Sediu social: Bucuresti Sectorul 4,<br>Bulevardul METALURGIEI, Nc 132, Bloc BIC, Etaj 4, Ap. 42.</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-phone-alt"></i>
                <p>+40 723 370 345</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-comment-alt"></i>
                <p>info@edxromania.ro</p>
            </div>
        </div>

        <div class="footer-column">
            <h3>About EDX</h3>
            <ul>
                <li><a href="<?php echo e(route('frontend.edx-world')); ?>">EDX World</a></li>
                <li><a href="<?php echo e(route('frontend.quality-path')); ?>">Quality Path</a></li>
                <li><a href="<?php echo e(route('frontend.industries')); ?>">Industries</a></li>
                <li><a href="<?php echo e(route('frontend.applications')); ?>">Applications</a></li>
                <li><a href="<?php echo e(route('frontend.contact')); ?>">Contact Us</a></li>
            </ul>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="copyright">
            <?php echo e(date('Y')); ?> © All Rights Reserved by Edx Rulmenti Romania Srl
        </div>
        <div class="social-links">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </div>
</footer>
<?php /**PATH F:\laragon\www\edx\resources\views/frontend/partials/footer.blade.php ENDPATH**/ ?>
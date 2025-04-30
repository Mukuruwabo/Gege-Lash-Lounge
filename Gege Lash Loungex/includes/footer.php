<!-- <link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/animation.css"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <!-- Quick Links Section -->
            <div class="footer-section animate__animated animate__fadeInUp">
                <h3 class="footer-heading">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="<?php echo BASE_URL; ?>" class="footer-link"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/services.php" class="footer-link"><i class="fas fa-chevron-right"></i> Services</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/about.php" class="footer-link"><i class="fas fa-chevron-right"></i> About</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/reviews.php" class="footer-link"><i class="fas fa-chevron-right"></i> Reviews</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/contact.php" class="footer-link"><i class="fas fa-chevron-right"></i> Contact</a></li>
                </ul>
            </div>

            <!-- Social Media Section -->
            <div class="footer-section animate__animated animate__fadeInUp animate__delay-1s">
                <h3 class="footer-heading">Connect With Us</h3>
                <div class="social-icons">
                    <a href="https://www.instagram.com/gege_lashes_lounge/profilecard/?igsh=M3p0MTE5dWhtcWg5" class="social-icon instagram" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://snapchat.com/t/jBrNX23I" class="social-icon facebook" title="Facebook"><i class="fab fa-snapchat"></i></a>
                    <a href="https://www.tiktok.com/@gege_lashes_lounge?_t=ZM-8vYcGug9zJV&_r=1" class="social-icon twitter" title="Twitter"><i class="fab fa-tiktok"></i></a>
                    <a href="http://wa.me/250788822851" class="social-icon whatsapp" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
                
                <div class="newsletter">
                    <h4>Subscribe to Newsletter</h4>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Your email address" required>
                        <button type="submit" class="btn-subscribe"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>

            <!-- Contact Info Section -->
            <div class="footer-section animate__animated animate__fadeInUp animate__delay-2s">
                <h3 class="footer-heading">Contact Info</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-phone contact-icon"></i>
                        <span><?php echo BUSINESS_PHONE; ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope contact-icon"></i>
                        <span><?php echo BUSINESS_EMAIL; ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt contact-icon"></i>
                        <span><?php echo BUSINESS_LOCATION; ?></span>
                    </div>
                </div>
                
                <div class="business-hours">
                    <h4>Working Hours</h4>
                    <p><i class="far fa-clock"></i> Mon-Fri: 9AM - 6PM</p>
                    <p><i class="far fa-clock"></i> Sat: 10AM - 4PM</p>
                    <p><i class="far fa-clock"></i> Sun: Closed</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom animate__animated animate__fadeIn">
        <div class="container">
            <div class="footer-bottom-content">
                <p class="copyright">&copy; <?php echo date('Y'); ?> Gege Lash Lounge. All rights reserved.</p>
                <div class="footer-legal">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
    
   
    <!-- <a href="#" class="back-to-top animate__animated animate__fadeInUp">
        <i class="fas fa-arrow-up"></i>
    </a> -->
</footer>

<style>
    /* Footer Styles */
    .footer {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #333;
        padding: 80px 0 0;
        position: relative;
        box-shadow: 0 -5px 30px rgba(0, 0, 0, 0.05);
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
        margin-bottom: 60px;
    }
    
    .footer-section {
        padding: 20px;
        transition: all 0.3s ease;
    }
    
    .footer-section:hover {
        transform: translateY(-5px);
    }
    
    .footer-heading {
        font-size: 1.5rem;
        margin-bottom: 25px;
        position: relative;
        color: #222;
        padding-bottom: 15px;
    }
    
    .footer-heading::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 3px;
        background: #D4AF37;
    }
    
    .footer-links {
        list-style: none;
        padding: 0;
    }
    
    .footer-link {
        display: block;
        padding: 10px 0;
        color: #555;
        transition: all 0.3s ease;
        position: relative;
        padding-left: 20px;
    }
    
    .footer-link i {
        position: absolute;
        left: 0;
        top: 12px;
        color: #D4AF37;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .footer-link:hover {
        color: #D4AF37;
        padding-left: 25px;
        text-decoration: none;
    }
    
    .footer-link:hover i {
        left: 5px;
    }
    
    /* Social Icons */
    .social-icons {
        display: flex;
        gap: 15px;
        margin: 25px 0;
    }
    
    .social-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    .social-icon:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }
    
    .instagram { background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888); }
    .facebook { background:rgba(255, 251, 0, 0.95); }
    .twitter { background:rgb(14, 14, 14); }
    .whatsapp { background: #25d366; }
    
    /* Newsletter */
    .newsletter {
        margin-top: 30px;
    }
    
    .newsletter h4 {
        font-size: 1.1rem;
        margin-bottom: 15px;
        color: #444;
    }
    
    .newsletter-form {
        display: flex;
    }
    
    .newsletter-form input {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 30px 0 0 30px;
        outline: none;
        font-size: 0.9rem;
    }
    
    .btn-subscribe {
        background: #D4AF37;
        color: white;
        border: none;
        padding: 0 20px;
        border-radius: 0 30px 30px 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-subscribe:hover {
        background: #B8860B;
    }
    
    /* Contact Info */
    .contact-info {
        margin-bottom: 30px;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .contact-icon {
        width: 40px;
        height: 40px;
        background: #D4AF37;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        flex-shrink: 0;
    }
    
    .business-hours p {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        color: #555;
    }
    
    .business-hours i {
        margin-right: 10px;
        color: #D4AF37;
    }
    
    /* Footer Bottom */
    .footer-bottom {
        background: rgba(0, 0, 0, 0.03);
        padding: 20px 0;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .copyright {
        color: #666;
        font-size: 0.9rem;
    }
    
    .footer-legal a {
        color: #666;
        margin-left: 20px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    
    .footer-legal a:hover {
        color: #D4AF37;
        text-decoration: none;
    }
    
    /* Back to Top Button */
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: #D4AF37;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        text-decoration: none;
        box-shadow: 0 5px 20px rgba(212, 175, 55, 0.3);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 999;
    }
    
    .back-to-top.active {
        opacity: 1;
        visibility: visible;
    }
    
    .back-to-top:hover {
        background: #B8860B;
        transform: translateY(-5px);
    }
    
    /* Responsive Styles */
    @media (max-width: 768px) {
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        
        .footer-bottom-content {
            flex-direction: column;
            text-align: center;
        }
        
        .footer-legal a {
            margin: 0 10px;
        }
        
        .newsletter-form {
            flex-direction: column;
        }
        
        .newsletter-form input {
            border-radius: 30px;
            margin-bottom: 10px;
        }
        
        .btn-subscribe {
            border-radius: 30px;
            padding: 12px;
        }
    }
</style>

<script>
// Back to Top Button
window.addEventListener('scroll', function() {
    var backToTop = document.querySelector('.back-to-top');
    if (window.pageYOffset > 300) {
        backToTop.classList.add('active');
        backToTop.classList.add('animate__fadeIn');
        backToTop.classList.remove('animate__fadeOut');
    } else {
        backToTop.classList.remove('animate__fadeIn');
        backToTop.classList.add('animate__fadeOut');
        setTimeout(function() {
            if (window.pageYOffset <= 300) {
                backToTop.classList.remove('active');
            }
        }, 500);
    }
});

// Smooth scrolling for footer links
document.querySelectorAll('.footer-link').forEach(link => {
    link.addEventListener('click', function(e) {
        if (this.getAttribute('href').startsWith('#')) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop,
                    behavior: 'smooth'
                });
            }
        }
    });
});

// Newsletter form submission
document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const email = this.querySelector('input').value;
    // Here you would typically send the email to your server
    alert('Thank you for subscribing with: ' + email);
    this.querySelector('input').value = '';
});
</script>

<!-- Your existing modals and scripts -->
<script src="<?php echo BASE_URL; ?>/assets/js/main.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/booking.js"></script>
</body>
</html>
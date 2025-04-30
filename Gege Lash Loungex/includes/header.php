<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gege Lash Lounge - Professional Eyelash Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #D4AF37;
            --gold-dark: #B8860B;
            --dark: #333333;
            --light-gray: #f5f5f5;
        }

        /* Notification Bar */
        .notification-bar {
            background-color: var(--primary);
            color: white;
            padding: 10px 0;
            text-align: center;
            position: relative;
            z-index: 1001;
            transition: all 0.3s ease;
        }

        .notification-bar p {
            margin: 0;
            font-size: 14px;
            display: inline-block;
        }

        .notification-cta {
            color: white;
            font-weight: bold;
            text-decoration: underline;
            margin-left: 10px;
        }

        .close-notification {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* Enhanced Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .header.scrolled {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-img {
            height: 40px;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .logo-text span {
            color: var(--primary);
        }

        /* Navigation */
        .nav-list {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            position: relative;
            margin: 0 15px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            color: var(--dark);
            text-decoration: none;
            padding: 10px 15px;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-icon {
            margin-right: 8px;
            font-size: 1rem;
        }

        .nav-hover {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-link:hover .nav-hover,
        .nav-link.active .nav-hover {
            width: 100%;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary);
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
        }

        .social-links {
            display: flex;
            margin-right: 10px;
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 25px;
            height: 35px;
            border-radius: 50%;
            background-color: var( --gold-dark);
            color: var(--dark);
            margin: 0 1px;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        /* Book Now Button */
        .btn-primary {
            background-color: var(--primary);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn-primary:hover {
            background-color: var(--gold-dark);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            cursor: pointer;
        }

        .hamburger {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 25px;
            height: 20px;
        }

        .hamburger-line {
            height: 2px;
            width: 100%;
            background-color: var(--dark);
            transition: all 0.3s ease;
        }

        .mobile-nav-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-nav {
            position: fixed;
            top: 0;
            right: -100%;
            width: 300px;
            height: 100%;
            background-color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .mobile-nav.active {
            right: 0;
        }

        .mobile-nav-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .mobile-nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--light-gray);
        }

        .close-mobile-nav {
            font-size: 1.5rem;
            cursor: pointer;
        }

        .mobile-nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-nav-list li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--dark);
            text-decoration: none;
            border-bottom: 1px solid var(--light-gray);
        }

        .mobile-nav-list li i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .mobile-dropdown > a {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-submenu {
            list-style: none;
            padding-left: 30px;
            display: none;
        }

        .mobile-dropdown.active .mobile-submenu {
            display: block;
        }

        .mobile-nav-footer {
            padding: 20px;
            text-align: center;
        }

        .mobile-social-links {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .mobile-social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-gray);
            color: var(--dark);
            margin: 0 10px;
        }

        .mobile-book-btn {
            width: 100%;
            justify-content: center;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .nav {
                display: none;
            }
            
            .mobile-menu {
                display: flex;
            }
            
            .header-actions .social-links {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .notification-bar p {
                font-size: 12px;
            }
            
            .logo-text {
                font-size: 1.2rem;
            }
            
            .btn-primary {
                padding: 8px 15px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .mobile-nav {
                width: 280px;
            }
            
            .logo-img {
                height: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Notification Bar -->
    <!-- <div class="notification-bar">
        <div class="header-container">
            <p>✨ Book your appointment today and get 10% off your first visit! <a href="#booking" class="notification-cta">Claim Offer</a></p>
            <span class="close-notification"><i class="fas fa-times"></i></span>
        </div>
    </div> -->

    <!-- Main Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <a href="index.html">
                    <img src="assets/images/logo.png" alt="" class="logo-img">
                    <span class="logo-text">Gege <span>Lash</span> Lounge</span>
                </a>
            </div>
            
            <nav class="nav">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="index.html" class="nav-link">
                            <i class="fas fa-home nav-icon"></i>
                            <span class="nav-text">Home</span>
                            <div class="nav-hover"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="services.html" class="nav-link">
                            <i class="fas fa-spa nav-icon"></i>
                            <span class="nav-text">Services</span>
                            <div class="nav-hover"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="about.html" class="nav-link">
                            <i class="fas fa-user nav-icon"></i>
                            <span class="nav-text">About</span>
                            <div class="nav-hover"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reviews.html" class="nav-link">
                            <i class="fas fa-star nav-icon"></i>
                            <span class="nav-text">Reviews</span>
                            <div class="nav-hover"></div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="contact.html" class="nav-link">
                            <i class="fas fa-phone nav-icon"></i>
                            <span class="nav-text">Contact</span>
                            <div class="nav-hover"></div>
                        </a>
                    </li>
                </ul>
            </nav>
            
            <!-- <div class="header-actions">
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                </div>
                 -->
                <div class="book-now">
                    <a href="#booking" class="btn btn-primary book-now-btn pulse-animation">
                        <i class="fas fa-calendar-check"></i> Book Now
                    </a>
                </div>
                
                <div class="mobile-menu">
                    <div class="hamburger">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation -->
    <div class="mobile-nav-overlay"></div>
    <nav class="mobile-nav">
        <div class="mobile-nav-header">
            <div class="logo">
                <a href="index.html">
                    <!-- <img src="assets/images/logo.png" alt="Gege Lash Lounge" class="logo-img"> -->
                    <span class="logo-text">Gege Lash Lounge</span>
                </a>
            </div>
            <div class="close-mobile-nav">
                <i class="fas fa-times"></i>
            </div>
        </div>
        <ul class="mobile-nav-list">
            <li><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="services.html"><i class="fas fa-spa"></i> Services</a></li>
            <li><a href="about.html"><i class="fas fa-user"></i> About</a></li>
            <li><a href="reviews.html"><i class="fas fa-star"></i> Reviews</a></li>
            <li><a href="contact.html"><i class="fas fa-phone"></i> Contact</a></li>
        </ul>
        <div class="mobile-nav-footer">
            <div class="mobile-social-links">
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>
            <a href="#booking" class="btn btn-primary mobile-book-btn">
                <i class="fas fa-calendar-check"></i> Book Appointment
            </a>
        </div>
    </nav>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu Toggle
            const mobileMenuBtn = document.querySelector('.mobile-menu');
            const mobileNav = document.querySelector('.mobile-nav');
            const mobileNavOverlay = document.querySelector('.mobile-nav-overlay');
            const closeMobileNav = document.querySelector('.close-mobile-nav');
            
            mobileMenuBtn.addEventListener('click', function() {
                mobileNav.classList.add('active');
                mobileNavOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
            
            closeMobileNav.addEventListener('click', function() {
                mobileNav.classList.remove('active');
                mobileNavOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            mobileNavOverlay.addEventListener('click', function() {
                mobileNav.classList.remove('active');
                mobileNavOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            // Close Notification Bar
            const closeNotification = document.querySelector('.close-notification');
            const notificationBar = document.querySelector('.notification-bar');
            
            if (closeNotification && notificationBar) {
                closeNotification.addEventListener('click', function() {
                    notificationBar.style.transform = 'translateY(-100%)';
                    setTimeout(() => {
                        notificationBar.style.display = 'none';
                    }, 300);
                });
            }
            
            // Header Scroll Effect
            const header = document.querySelector('.header');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
            
            // Active Navigation Link
            const navLinks = document.querySelectorAll('.nav-link, .mobile-nav-list a');
            const currentPage = window.location.pathname.split('/').pop() || 'index.html';
            
            navLinks.forEach(link => {
                // Remove active class from all links first
                link.classList.remove('active');
                
                // Get the href attribute and extract just the filename
                const linkHref = link.getAttribute('href').split('/').pop();
                
                // Compare with current page
                if (linkHref === currentPage) {
                    link.classList.add('active');
                }
            });
            
            // Smooth scrolling for same-page links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
<?php include 'includes/config.php'; ?>
<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gege Lash Lounge - Premium Eyelash Extensions</title>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"> -->
    <style>
         :root {
            --primary-color: #D4AF37;
            --secondary-color: #ffffff;
            --accent-color: #f9f9f9;
            --text-color: #333333;
            --light-gray: #f5f5f5;
            --medium-gray: #dddddd;
            --dark-gray: #666666;
            --gold-light: #E8C872;
            --gold-dark: #B8860B;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            --ease-out: cubic-bezier(0, 0.55, 0.45, 1);
        }

        /* Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
            background-color: var(--secondary-color);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        p {
            margin-bottom: 1rem;
            color: var(--text-color);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        ul {
            list-style: none;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Enhanced Button Styles */
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border: none;
            border-radius: 50px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn:hover {
            background-color: var(--gold-dark);
            color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(212, 175, 55, 0.4);
        }

        .btn:active {
            transform: translateY(1px);
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background-color: var(--primary-color);
            color: var(--secondary-color);
        }

        /* Section Styles with Animations */
        .section-title {
            font-size: 2.5rem;
            color: var(--text-color);
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s var(--ease-out);
        }

        .section-title.in-view {
            opacity: 1;
            transform: translateY(0);
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 4px;
            background-color: var(--primary-color);
            transform-origin: left center;
            transform: scaleX(0);
            transition: transform 0.6s var(--ease-out) 0.3s;
        }

        .section-title.in-view::after {
            transform: scaleX(1);
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--dark-gray);
            margin-bottom: 3rem;
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s var(--ease-out) 0.2s;
        }

        .section-subtitle.in-view {
            opacity: 1;
            transform: translateY(0);
        }

        /* Header with Scroll Effects */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.4s var(--ease-out);
            transform: translateY(0);
        }

        .header.hidden {
            transform: translateY(-100%);
        }

        .header.scrolled {
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            height: 70px;
        }

        .header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
            transition: height 0.3s var(--ease-out);
        }

        .header.scrolled .container {
            height: 70px;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-color);
            transition: var(--transition);
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo span {
            color: var(--primary-color);
        }

        .nav ul {
            display: flex;
        }

        .nav ul li {
            margin-left: 30px;
            position: relative;
        }

        .nav ul li a {
            font-weight: 500;
            color: var(--text-color);
            padding: 5px 0;
            position: relative;
            transition: var(--transition);
        }

        .nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary-color);
            transition: var(--transition);
        }

        .nav ul li a:hover::after {
            width: 100%;
        }

        .nav ul li a:hover {
            color: var(--primary-color);
        }

        .book-now-btn {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(212, 175, 55, 0.3);
        }

        .book-now-btn:hover {
            background-color: var(--gold-dark);
            color: var(--secondary-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(212, 175, 55, 0.4);
        }

        .mobile-menu {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-color);
            transition: var(--transition);
        }

        .mobile-menu:hover {
            color: var(--primary-color);
            transform: rotate(90deg);
        }

.hero {
    height: 100vh;
    min-height: 700px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 80px;
    overflow: hidden;
    perspective: 100px;
}

.hero-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: 0;
    filter: brightness(0.7) contrast(1.1);
    transform: translateZ(-1px) scale(1.02);
    will-change: transform;
    animation: heroZoom 20s infinite alternate ease-in-out;
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.3) 0%, rgba(0, 0, 0, 0.1) 100%);
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 10;
    text-align: center;
    color: white;
    max-width: 800px;
    padding: 0 20px;
    transform: translateY(20px);
    opacity: 0;
    transition: all 0.8s cubic-bezier(0.25, 0.8, 0.25, 1) 0.2s;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.hero-content.visible {
    transform: translateY(0);
    opacity: 1;
}

.hero-content h1 {
    font-size: 3.5rem;
    margin-bottom: 20px;
    animation: float 6s ease-in-out infinite;
    line-height: 1.2;
    color: white;
}

.hero-content p {
    font-size: 1.5rem;
    margin-bottom: 30px;
    animation: float 6s ease-in-out infinite 0.5s;
    color: white;
}

.btn-glow {
    animation: pulse 2s infinite;
}

.scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    animation: bounce 2s infinite;
}

.scroll-indicator span {
    display: block;
    width: 20px;
    height: 20px;
    border-bottom: 2px solid white;
    border-right: 2px solid white;
    transform: rotate(45deg);
    margin: -10px;
}

/* Floating Bubbles Animation */
.floating-circles {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 1;
    overflow: hidden;
}

.floating-circles li {
    position: absolute;
    display: block;
    list-style: none;
    width: 20px;
    height: 20px;
    background: rgba(255, 255, 255, 0.15);
    animation: floating 25s linear infinite;
    bottom: -150px;
    border-radius: 50%;
}

/* Keyframes */
@keyframes heroZoom {
    0% {
        transform: scale(1) translateZ(-1px);
    }
    100% {
        transform: scale(1.05) translateZ(-1px);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.4);
    }
    70% {
        box-shadow: 0 0 0 15px rgba(212, 175, 55, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(212, 175, 55, 0);
    }
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0) translateX(-50%);
    }
    40% {
        transform: translateY(-20px) translateX(-50%);
    }
    60% {
        transform: translateY(-10px) translateX(-50%);
    }
}

@keyframes floating {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
        border-radius: 0;
    }
    100% {
        transform: translateY(-1000px) rotate(720deg);
        opacity: 0;
        border-radius: 50%;
    }
}
/* Enhanced Services Section */
.services-preview {
    padding: 100px 0;
    background-color: var(--secondary-color);
    position: relative;
    overflow: hidden;
}

.services-preview::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect fill="%23D4AF37" fill-opacity="0.05" width="50" height="50" x="0" y="0"></rect></svg>');
    background-size: 20px 20px;
    opacity: 0.1;
    z-index: 0;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
    margin-top: 50px;
}

.service-card {
    background-color: var(--secondary-color);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
    transform: translateY(50px);
    opacity: 0;
    position: relative;
    z-index: 1;
}

.service-card.in-view {
    transform: translateY(0);
    opacity: 1;
}

.service-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.service-card:hover .service-image {
    transform: scale(1.05);
}

.service-image {
    height: 250px;
    position: relative;
    background-size: cover;
    background-position: center;
    transition: transform 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.service-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.3), transparent);
}

.service-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background-color: var(--primary-color);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    z-index: 2;
}

.service-content {
    padding: 25px;
    position: relative;
}

.service-content h3 {
    font-size: 1.5rem;
    color: var(--text-color);
    margin-bottom: 10px;
}

.service-desc {
    color: var(--dark-gray);
    font-size: 0.95rem;
    margin-bottom: 15px;
    min-height: 40px;
}

.price {
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 15px;
}

.service-meta {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    font-size: 0.85rem;
    color: var(--dark-gray);
}

.service-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Coming Soon Card */
.service-card.coming-soon {
    position: relative;
}

.service-card.coming-soon::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.7);
    z-index: 1;
}

.coming-soon-label {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: var(--primary-color);
    color: white;
    padding: 10px 25px;
    border-radius: 30px;
    font-weight: 600;
    z-index: 2;
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
}

.notify-btn {
    width: 100%;
    background-color: var(--dark-gray);
    cursor: not-allowed;
}

.notify-btn:hover {
    background-color: var(--dark-gray);
    transform: none;
}
/* Enhanced About Section */
.about-section {
    padding: 100px 0;
    background-color: white;
    position: relative;
    overflow: hidden;
}

.about-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect fill="%23D4AF37" fill-opacity="0.05" width="50" height="50" x="0" y="0"></rect></svg>');
    background-size: 20px 20px;
    opacity: 0.3;
    z-index: 0;
}

.about-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    align-items: center;
    position: relative;
    z-index: 1;
}

.about-text h3 {
    font-size: 2rem;
    color: var(--text-color);
    margin-bottom: 20px;
    position: relative;
    display: inline-block;
}

.about-text h3::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 60px;
    height: 3px;
    background-color: var(--primary-color);
}

.about-text p {
    margin-bottom: 25px;
    color: var(--text-color);
    font-size: 1.1rem;
    line-height: 1.7;
}

.about-highlights {
    margin-top: 40px;
}

.highlight-item {
    display: flex;
    margin-bottom: 20px;
    transform: translateX(-20px);
    opacity: 0;
    transition: all 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
    padding: 15px;
    border-radius: 10px;
    background-color: rgba(212, 175, 55, 0.05);
}

.highlight-item.in-view {
    transform: translateX(0);
    opacity: 1;
}

.highlight-item:hover {
    background-color: rgba(212, 175, 55, 0.1);
    transform: translateX(5px);
}

.highlight-icon {
    width: 50px;
    height: 50px;
    background-color: var(--primary-color);
    color: var(--secondary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-right: 15px;
    flex-shrink: 0;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.highlight-item:hover .highlight-icon {
    transform: rotate(15deg) scale(1.1);
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
}

.highlight-content h4 {
    font-size: 1.1rem;
    color: var(--text-color);
    margin-bottom: 5px;
}

.highlight-content p {
    font-size: 0.9rem;
    color: var(--dark-gray);
    margin-bottom: 0;
}

/* Owner Card */
.owner-card {
    background-color: var(--secondary-color);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
    max-width: 400px;
    margin-left: auto;
    transform: translateY(50px) rotate(2deg);
    opacity: 0;
}

.owner-card.in-view {
    transform: translateY(0) rotate(0);
    opacity: 1;
    transition-delay: 0.3s;
}

.owner-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
}

.owner-image {
    position: relative;
    overflow: hidden;
    height: 350px;
}

.owner-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.owner-card:hover .owner-image img {
    transform: scale(1.05);
}

.certificate-badge {
    position: absolute;
    bottom: 20px;
    left: 20px;
    background-color: var(--primary-color);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    z-index: 2;
}

.owner-info {
    padding: 25px;
    text-align: center;
}

.owner-info h3 {
    font-size: 1.5rem;
    margin-bottom: 5px;
    color: var(--text-color);
}

.owner-info p {
    color: var(--dark-gray);
    margin-bottom: 15px;
}

.owner-rating {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 15px 0;
}

.stars {
    color: var(--primary-color);
    margin-right: 10px;
}

.owner-social {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}

.owner-social .social-icon {
    width: 35px;
    height: 35px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.owner-social .social-icon:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
}
/* Enhanced Reviews Section */
.reviews-section {
    padding: 100px 0;
    background-color: var(--light-gray);
    position: relative;
    overflow: hidden;
}

.reviews-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect fill="%23D4AF37" fill-opacity="0.05" width="50" height="50" x="50" y="50"></rect></svg>');
    background-size: 20px 20px;
    opacity: 0.1;
    z-index: 0;
}

.reviews-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.review-card {
    background-color: var(--secondary-color);
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
    transform: scale(0.95);
    opacity: 0;
    position: relative;
    z-index: 1;
}

.review-card.in-view {
    transform: scale(1);
    opacity: 1;
}

.review-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

.review-card::before {
    content: '"';
    position: absolute;
    top: 20px;
    right: 30px;
    font-size: 5rem;
    color: rgba(212, 175, 55, 0.1);
    font-family: serif;
    line-height: 1;
    z-index: 0;
}

.review-header {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    position: relative;
    z-index: 1;
}

.reviewer-avatar {
    width: 60px;
    height: 60px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.5rem;
    margin-right: 15px;
    flex-shrink: 0;
}

.reviewer-info h4 {
    font-size: 1.2rem;
    color: var(--text-color);
    margin-bottom: 5px;
}

.review-content {
    margin-bottom: 15px;
    position: relative;
    z-index: 1;
}

.review-content p {
    font-style: italic;
    color: var(--dark-gray);
    line-height: 1.7;
}

.review-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.9rem;
    color: var(--dark-gray);
    position: relative;
    z-index: 1;
}

.service-tag {
    background-color: var(--primary-color);
    color: white;
    padding: 3px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.reviews-cta {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 50px;
}

@media (max-width: 768px) {
    .reviews-cta {
        flex-direction: column;
        align-items: center;
    }
}
/* Enhanced Contact Section */
.contact-section {
    padding: 100px 0;
    background-color: var(--accent-color);
    position: relative;
    overflow: hidden;
}

.contact-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect fill="%23D4AF37" fill-opacity="0.05" width="50" height="50" x="50" y="50"></rect></svg>');
    background-size: 20px 20px;
    opacity: 0.1;
    z-index: 0;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 50px;
    position: relative;
    z-index: 1;
}

.contact-info {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.contact-details {
    margin-bottom: 30px;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    transform: translateX(-20px);
    opacity: 0;
    transition: all 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
    padding: 15px;
    border-radius: 10px;
    background-color: rgba(255, 255, 255, 0.8);
}

.contact-item.in-view {
    transform: translateX(0);
    opacity: 1;
}

.contact-item:hover {
    background-color: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.contact-icon {
    width: 50px;
    height: 50px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-right: 15px;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.contact-item:hover .contact-icon {
    transform: rotate(15deg) scale(1.1);
}

.contact-content h4 {
    font-size: 1.2rem;
    margin-bottom: 5px;
    color: var(--text-color);
}

.contact-content p {
    color: var(--dark-gray);
    margin-bottom: 0;
}

.contact-social {
    margin-bottom: 30px;
}

.contact-social h4 {
    margin-bottom: 15px;
    color: var(--text-color);
}

.social-icons {
    display: flex;
    gap: 15px;
}

.social-icon {
    width: 45px;
    height: 45px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.social-icon:hover {
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
}

.contact-form {
    background-color: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.contact-form h4 {
    margin-bottom: 20px;
    color: var(--text-color);
}

.contact-form .form-group {
    margin-bottom: 15px;
}

.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--medium-gray);
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    transition: all 0.3s ease;
}

.contact-form input:focus,
.contact-form textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
    outline: none;
}

.contact-form textarea {
    min-height: 100px;
    resize: vertical;
}

.contact-form button {
    width: 100%;
}

.contact-map {
    height: 100%;
    min-height: 500px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    transform: translateY(50px);
    opacity: 0;
    transition: all 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.contact-map.in-view {
    transform: translateY(0);
    opacity: 1;
}

.contact-map iframe {
    width: 100%;
    height: 100%;
    border: none;
}

@media (max-width: 992px) {
    .contact-grid {
        grid-template-columns: 1fr;
    }
    
    .contact-map {
        min-height: 400px;
    }
}
/* Enhanced Booking Modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 2000;
    opacity: 0;
    transition: opacity 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    overflow-y: auto;
    padding: 20px;
    align-items: center;
    justify-content: center;
}

.modal.show {
    display: flex;
    opacity: 1;
}

.modal-content {
    background-color: var(--secondary-color);
    margin: auto;
    width: 90%;
    max-width: 600px;
    border-radius: 15px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
    transform: translateY(-50px);
    opacity: 0;
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    max-height: 90vh;
    overflow-y: auto;
}

.modal.show .modal-content {
    transform: translateY(0);
    opacity: 1;
}

.modal-header {
    padding: 25px;
    border-bottom: 1px solid var(--medium-gray);
    position: relative;
    text-align: center;
}

.modal-header h2 {
    font-size: 1.8rem;
    color: var(--text-color);
    margin-bottom: 5px;
}

.modal-header p {
    color: var(--dark-gray);
    font-size: 0.9rem;
}

.close-modal {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--dark-gray);
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.close-modal:hover {
    color: var(--primary-color);
    transform: rotate(90deg);
}

.modal-body {
    padding: 25px;
}

.form-row {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.form-group {
    flex: 1;
    min-width: 200px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--text-color);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--medium-gray);
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
    outline: none;
}

.form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.form-actions {
    margin-top: 30px;
    text-align: center;
}

#payNowBtn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 30px;
    width: 100%;
}

.btn-icon {
    transition: all 0.3s ease;
}

#payNowBtn:hover .btn-icon {
    transform: translateX(5px);
}

.form-note {
    font-size: 0.8rem;
    color: var(--dark-gray);
    margin-top: 15px;
    text-align: center;
}

@media (max-width: 768px) {
    .modal {
        padding: 10px;
        align-items: flex-start;
    }
    
    .modal-content {
        margin: 20px;
        width: calc(100% - 40px);
    }
    
    .form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .form-group {
        min-width: 100%;
    }
}
/* Enhanced Payment Modal */
.payment-instructions {
    margin-bottom: 30px;
    padding: 0 25px;
}

.payment-instructions h3 {
    margin-bottom: 15px;
    color: var(--text-color);
    font-size: 1.3rem;
}

.payment-instructions p {
    margin-bottom: 20px;
    color: var(--dark-gray);
}

.payment-method {
    display: flex;
    align-items: center;
    background-color: rgba(212, 175, 55, 0.1);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    border: 1px solid rgba(212, 175, 55, 0.2);
    transition: all 0.3s ease;
}

.payment-method:hover {
    background-color: rgba(212, 175, 55, 0.15);
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.payment-icon {
    width: 60px;
    height: 60px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 20px;
    flex-shrink: 0;
}

.payment-content h4 {
    margin-bottom: 10px;
    color: var(--text-color);
}

.payment-details {
    display: flex;
    gap: 20px;
}

.payment-number,
.payment-name {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.9rem;
    color: var(--dark-gray);
}

.payment-number i,
.payment-name i {
    color: var(--primary-color);
}

.payment-steps {
    background-color: rgba(212, 175, 55, 0.1);
    padding: 20px;
    border-radius: 10px;
    border: 1px solid rgba(212, 175, 55, 0.2);
}

.payment-steps h4 {
    margin-bottom: 10px;
    color: var(--text-color);
}

.payment-steps ol {
    padding-left: 20px;
    color: var(--dark-gray);
}

.payment-steps li {
    margin-bottom: 5px;
}

#confirmPaymentBtn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 15px 30px;
    width: 100%;
}

#confirmPaymentBtn .btn-icon {
    transition: all 0.3s ease;
}

#confirmPaymentBtn:hover .btn-icon {
    transform: scale(1.2);
}
/* Enhanced Confirmation Modal */
.confirmation-icon {
    margin: 20px 0;
    animation: bounceIn 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
}

.booking-details {
    margin: 20px 0;
    background: rgba(212, 175, 55, 0.1);
    padding: 20px;
    border-radius: 10px;
    text-align: left;
    border: 1px solid rgba(212, 175, 55, 0.2);
}

.booking-details h4 {
    margin-bottom: 15px;
    color: var(--text-color);
    text-align: center;
}

.booking-details p {
    margin-bottom: 8px;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 8px;
}

.booking-details p::before {
    content: '✓';
    color: var(--primary-color);
    font-weight: bold;
}

.booking-actions {
    display: flex;
    gap: 15px;
    margin: 25px 0;
}

.booking-actions a {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

@keyframes bounceIn {
    0% {
        transform: scale(0.1);
        opacity: 0;
    }
    60% {
        transform: scale(1.2);
        opacity: 1;
    }
    100% {
        transform: scale(1);
    }
}
    </style>
</head>
<body>
<!-- Hero Section -->
<section class="hero" id="home">
    <div class="hero-image" style="background-image: url('./assets/images/hero.jpeg');">
        <div class="hero-overlay"></div>
        
        <!-- Floating circles animation -->
        <ul class="floating-circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        
        <!-- <div class="hero-content">
            <h1>Elevate Your Beauty with Gege Lash Lounge</h1>
            <p>Experience luxurious eyelash extensions tailored just for you</p>
            <a href="#" class="btn btn-glow book-now-btn">Book Your Transformation</a>
        </div>
         -->
        <div class="scroll-indicator">
            <span></span>
        </div>
    </div>
</section>

   <!-- Services Section -->
<section class="services-preview" id="services">
    <div class="container">
        <h2 class="section-title">Our Premium Services</h2>
        <p class="section-subtitle">Enhance your natural beauty with our expert lash extensions</p>
        
        <div class="services-grid">
            <div class="service-card">
                <div class="service-image" style="background-image: url('assets/images/services/classic-lashes.png');">
                    <div class="service-overlay"></div>
                    <div class="service-badge">Most Popular</div>
                </div>
                <div class="service-content">
                    <h3>Classic Lashes</h3>
                    <p class="service-desc">Natural-looking extensions that enhance your lashes</p>
                    <p class="price">25,000 RWF</p>
                    <div class="service-meta">
                        <span><i class="fas fa-clock"></i> 90 mins</span>
                        <span><i class="fas fa-calendar-alt"></i> 3-4 week fill</span>
                    </div>
                    <a href="#" class="btn book-now-btn" data-service="1">Book Now</a>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-image" style="background-image: url('assets/images/services/hybrid-lashes.jpeg');">
                    <div class="service-overlay"></div>
                </div>
                <div class="service-content">
                    <h3>Hybrid Lashes</h3>
                    <p class="service-desc">Mix of classic and volume for a fuller look</p>
                    <p class="price">30,000 RWF</p>
                    <div class="service-meta">
                        <span><i class="fas fa-clock"></i> 120 mins</span>
                        <span><i class="fas fa-calendar-alt"></i> 3-4 week fill</span>
                    </div>
                    <a href="#" class="btn book-now-btn" data-service="2">Book Now</a>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-image" style="background-image: url('assets/images/services/volume-lashes.jpeg');">
                    <div class="service-overlay"></div>
                    <div class="service-badge">Trending</div>
                </div>
                <div class="service-content">
                    <h3>Volume Lashes</h3>
                    <p class="service-desc">Dramatic, full look with multiple extensions</p>
                    <p class="price">35,000 RWF</p>
                    <div class="service-meta">
                        <span><i class="fas fa-clock"></i> 150 mins</span>
                        <span><i class="fas fa-calendar-alt"></i> 2-3 week fill</span>
                    </div>
                    <a href="#" class="btn book-now-btn" data-service="3">Book Now</a>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-image" style="background-image: url('assets/images/services/Megavolume-lashes.jpeg');">
                    <div class="service-overlay"></div>
                    <div class="service-badge">Luxury</div>
                </div>
                <div class="service-content">
                    <h3>Mega Volume</h3>
                    <p class="service-desc">Ultimate glamour with ultra-lightweight lashes</p>
                    <p class="price">40,000 RWF</p>
                    <div class="service-meta">
                        <span><i class="fas fa-clock"></i> 180 mins</span>
                        <span><i class="fas fa-calendar-alt"></i> 2-3 week fill</span>
                    </div>
                    <a href="#" class="btn book-now-btn" data-service="4">Book Now</a>
                </div>
            </div>
            
            <div class="service-card coming-soon">
                <div class="service-image" style="background-image: url('assets/images/services/coming-soon.jpeg');">
                    <div class="service-overlay"></div>
                    <div class="coming-soon-label">Coming Soon</div>
                </div>
                <div class="service-content">
                    <h3>Lash Lift & Tint</h3>
                    <p class="service-desc">Enhance your natural lashes without extensions</p>
                    <p class="price">TBA</p>
                    <button class="btn notify-btn">Notify Me</button>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- About Section -->
   <!-- About Section -->
<section class="about-section" id="about">
    <div class="container">
        <h2 class="section-title">About Gege Lash Lounge</h2>
        <p class="section-subtitle">Where beauty meets perfection</p>
        
        <div class="about-content">
            <div class="about-text">
                <h3>Our Story</h3>
                <p>Founded in 2018, Gege Lash Lounge has been transforming the beauty landscape in Kigali with our premium eyelash extension services. We believe that every client deserves personalized attention and the highest quality products.</p>
                
                <div class="about-highlights">
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="highlight-content">
                            <h4>Certified Professionals</h4>
                            <p>Our team is trained at Rwanda Beauty Academy with 5+ years of experience in lash artistry.</p>
                        </div>
                    </div>
                    
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="highlight-content">
                            <h4>Premium Quality</h4>
                            <p>We use only medical-grade adhesives and the finest materials imported from Europe.</p>
                        </div>
                    </div>
                    
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="highlight-content">
                            <h4>Personalized Service</h4>
                            <p>Each lash design is customized for your unique eye shape and personal style.</p>
                        </div>
                    </div>
                    
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <i class="fas fa-spa"></i>
                        </div>
                        <div class="highlight-content">
                            <h4>Luxury Experience</h4>
                            <p>Relax in our serene lounge with complimentary beverages and soothing music.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="about-image">
                <div class="owner-card">
                    <div class="owner-image">
                        <img src="assets/images/owner.jpeg" alt="Mwizerwa Germaine">
                        <div class="certificate-badge">
                            <i class="fas fa-certificate"></i> Certified Lash Artist
                        </div>
                    </div>
                    <div class="owner-info">
                        <h3>Mwizerwa Germaine</h3>
                        <p>Founder & Lead Artist</p>
                        <div class="owner-rating">
                            <div class="stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span>4.8 (120 reviews)</span>
                        </div>
                        <div class="owner-social">
                            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

   <!-- Reviews Section -->
<section class="reviews-section" id="reviews">
    <div class="container">
        <h2 class="section-title">Client Love</h2>
        <p class="section-subtitle">What our clients say about their experience</p>
        
        <div class="reviews-grid">
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-avatar">A</div>
                    <div class="reviewer-info">
                        <h4>Alice K.</h4>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="review-content">
                    <p>"Germaine is truly an artist! My lashes looked absolutely stunning and lasted for weeks. The salon is clean and comfortable, and the service was exceptional. I've never felt more pampered!"</p>
                </div>
                <div class="review-footer">
                    <span><i class="fas fa-calendar-alt"></i> 2 weeks ago</span>
                    <span class="service-tag">Volume Lashes</span>
                </div>
            </div>
            
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-avatar">B</div>
                    <div class="reviewer-info">
                        <h4>Beatrice M.</h4>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="review-content">
                    <p>"I've been to many lash technicians, but none compare to the precision and care Germaine provides. My hybrid lashes look so natural yet glamorous! Worth every franc."</p>
                </div>
                <div class="review-footer">
                    <span><i class="fas fa-calendar-alt"></i> 1 month ago</span>
                    <span class="service-tag">Hybrid Lashes</span>
                </div>
            </div>
            
            <div class="review-card">
                <div class="review-header">
                    <div class="reviewer-avatar">C</div>
                    <div class="reviewer-info">
                        <h4>Claire U.</h4>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                    </div>
                </div>
                <div class="review-content">
                    <p>"The mega volume lashes transformed my look completely. Germaine took the time to understand exactly what I wanted and delivered beyond my expectations. I get compliments daily!"</p>
                </div>
                <div class="review-footer">
                    <span><i class="fas fa-calendar-alt"></i> 3 weeks ago</span>
                    <span class="service-tag">Mega Volume</span>
                </div>
            </div>
        </div>
        
        <div class="reviews-cta">
            <a href="#" class="btn">Leave a Review</a>
            <a href="#" class="btn btn-outline">View All Reviews</a>
        </div>
    </div>
</section>

    <!-- Contact Section -->
<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <h2 class="section-title">Get In Touch</h2>
        <p class="section-subtitle">We'd love to hear from you</p>
        
        <div class="contact-grid">
            <div class="contact-info">
                <div class="contact-details">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Location</h4>
                            <p>Remera-Kisimenti-Akeza house 4 floor</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Phone</h4>
                            <p><?php echo BUSINESS_PHONE; ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Email</h4>
                            <p><?php echo BUSINESS_EMAIL; ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Working Hours</h4>
                            <p>Mon-Fri: 9AM - 6PM<br>Sat: 10AM - 4PM<br>Sun: Closed</p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-social">
                    <h4>Follow Us</h4>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h4>Send Us a Message</h4>
                    <form id="quickContactForm">
                        <div class="form-group">
                            <input type="text" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <textarea placeholder="Your Message" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn">Send Message</button>
                    </form>
                </div>
            </div>
            
            <div class="contact-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.490895534721!2d30.0582153153286!3d-1.9535375379990545!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwNTcnMTIuNyJTIDMwwrAwMyczNS4xIkU!5e0!3m2!1sen!2srw!4v1620000000000!5m2!1sen!2srw" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
    <!-- Booking Modal -->
    <!-- Booking Modal -->
<div class="modal" id="bookingModal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <div class="modal-header">
            <h2>Book Your Appointment</h2>
            <p>Fill out the form below to reserve your session</p>
        </div>
        <form id="bookingForm" action="booking-process.php" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Full Name</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="service">Service</label>
                    <select id="service" name="service" required>
                        <option value="">Select a service</option>
                        <option value="1">Classic - 25,000 RWF</option>
                        <option value="2">Hybrid - 30,000 RWF</option>
                        <option value="3">Volume - 35,000 RWF</option>
                        <option value="4">Mega Volume - 40,000 RWF</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="time">Time</label>
                    <select id="time" name="time" required>
                        <option value="">Select a time</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="request">Special Requests</label>
                <textarea id="request" name="request" placeholder="Any special requirements or notes..."></textarea>
            </div>
            <div class="form-actions">
                <button type="button" id="payNowBtn" class="btn">
                    <span class="btn-text">Pay Now (10,000 RWF Deposit)</span>
                    <span class="btn-icon"><i class="fas fa-lock"></i></span>
                </button>
                <p class="form-note">Your appointment will be confirmed after payment verification</p>
            </div>
        </form>
    </div>
</div>

    <!-- Payment Modal -->
   <!-- Payment Modal -->
<div class="modal" id="paymentModal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <div class="modal-header">
            <h2>Complete Your Payment</h2>
            <p>Secure your appointment with a deposit</p>
        </div>
        <div class="payment-instructions">
            <h3>Payment Instructions</h3>
            <p>Please send exactly <strong>10,000 RWF</strong> to:</p>
            
            <div class="payment-method">
                <div class="payment-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="payment-content">
                    <h4>Mobile Money</h4>
                    <div class="payment-details">
                        <div class="payment-number">
                            <i class="fas fa-phone"></i>
                            <span><?php echo BUSINESS_PHONE; ?></span>
                        </div>
                        <div class="payment-name">
                            <i class="fas fa-user"></i>
                            <span>Gege Lash Lounge</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="payment-steps">
                <h4>After payment:</h4>
                <ol>
                    <li>Complete the transfer using the number above</li>
                    <li>Take a screenshot of the payment confirmation</li>
                    <li>Click the confirmation button below</li>
                </ol>
            </div>
        </div>
        
        <form id="paymentConfirmationForm">
            <div class="form-actions">
                <button type="button" id="confirmPaymentBtn" class="btn">
                    <span class="btn-text">I Have Paid 10,000 RWF</span>
                    <span class="btn-icon"><i class="fas fa-check-circle"></i></span>
                </button>
                <p class="form-note">Your booking will be confirmed once payment is verified</p>
            </div>
        </form>
    </div>
</div>

 <!-- Confirmation Modal -->
<div class="modal" id="confirmationModal">
    <div class="modal-content" style="max-width: 500px; text-align: center;">
        <div class="modal-header">
            <h2>Booking Confirmed!</h2>
            <p>Thank you for your payment</p>
        </div>
        <div class="modal-body">
            <div class="confirmation-icon">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" fill="#D4AF37"/>
                    <path d="M8 12L11 15L16 9" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <p>Your appointment has been successfully booked.</p>
            <p>We've sent a confirmation to your email with all the details.</p>
            <div class="booking-details">
                <h4>Booking Summary</h4>
                <p id="confirmationService"></p>
                <p id="confirmationDate"></p>
                <p id="confirmationTime"></p>
            </div>
            <div class="booking-actions">
                <a href="#" class="btn btn-outline"><i class="fas fa-calendar-alt"></i> Add to Calendar</a>
                <a href="#" class="btn"><i class="fas fa-share-alt"></i> Share</a>
            </div>
        </div>
        <div class="form-actions">
            <button type="button" id="closeConfirmationBtn" class="btn">Done</button>
        </div>
    </div>
</div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations
    initAnimations();
    
    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu');
    const nav = document.querySelector('.nav');
    
    if (mobileMenuBtn && nav) {
        mobileMenuBtn.addEventListener('click', function() {
            nav.classList.toggle('active');
            this.querySelector('i').classList.toggle('fa-bars');
            this.querySelector('i').classList.toggle('fa-times');
        });
    }
    
    // Smooth scrolling for navigation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                if (nav && nav.classList.contains('active')) {
                    nav.classList.remove('active');
                    mobileMenuBtn.querySelector('i').classList.remove('fa-times');
                    mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                }
            }
        });
    });
    
    // Hero content animation
    const heroContent = document.querySelector('.hero-content');
    setTimeout(() => {
        heroContent.classList.add('visible');
    }, 300);
    
    // Scroll header effect
    let lastScroll = 0;
    const header = document.querySelector('.header');
    
    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll <= 0) {
            header.classList.remove('scrolled', 'hidden');
            return;
        }
        
        if (currentScroll > lastScroll && !header.classList.contains('hidden')) {
            header.classList.add('hidden');
        } else if (currentScroll < lastScroll && header.classList.contains('hidden')) {
            header.classList.remove('hidden');
        }
        
        if (currentScroll > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });
    
    // Modal functionality
    const modals = {
        bookingModal: document.getElementById('bookingModal'),
        paymentModal: document.getElementById('paymentModal'),
        confirmationModal: document.getElementById('confirmationModal')
    };
    
    // Open modal
    document.querySelectorAll('.book-now-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            openModal('bookingModal');
            
            // Preselect service if data attribute exists
            if (this.dataset.service) {
                document.getElementById('service').value = this.dataset.service;
            }
        });
    });
    
    // Close modal
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', function() {
            closeModal(this.closest('.modal').id);
        });
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            closeModal(e.target.id);
        }
    });
    
    // Form submission
    document.getElementById('payNowBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        if (validateForm()) {
            closeModal('bookingModal');
            openModal('paymentModal');
        }
    });
    
    // Confirm payment button
    document.getElementById('confirmPaymentBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Show loading state
        const btnText = this.querySelector('.btn-text');
        const originalText = btnText.textContent;
        btnText.textContent = 'Processing...';
        this.disabled = true;
        
        // Get booking details for confirmation modal
        const service = document.getElementById('service').options[document.getElementById('service').selectedIndex].text;
        const date = document.getElementById('date').value;
        const time = document.getElementById('time').value;
        
        // Format date for display
        const formattedDate = new Date(date).toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Set confirmation details
        document.getElementById('confirmationService').textContent = `Service: ${service}`;
        document.getElementById('confirmationDate').textContent = `Date: ${formattedDate}`;
        document.getElementById('confirmationTime').textContent = `Time: ${time}`;
        
        // Submit the form after a brief delay to show processing state
        setTimeout(() => {
            document.getElementById('bookingForm').submit();
        }, 1500);
    });
    
    // Close confirmation modal
    document.getElementById('closeConfirmationBtn')?.addEventListener('click', function() {
        closeModal('confirmationModal');
    });
    
    // Animation observer
    function initAnimations() {
        const animateElements = document.querySelectorAll('.section-title, .section-subtitle, .service-card, .highlight-item, .owner-card, .review-card, .contact-item, .contact-map');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        
        animateElements.forEach(el => observer.observe(el));
    }
    
    // Modal functions
    function openModal(modalId) {
        const modal = modals[modalId];
        modal.style.display = 'flex';
        // Force reflow to enable transition
        void modal.offsetHeight;
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // Scroll to top of modal content
        const modalContent = modal.querySelector('.modal-content');
        if (modalContent) {
            modalContent.scrollTop = 0;
        }
    }

    function closeModal(modalId) {
        const modal = modals[modalId];
        modal.classList.remove('show');
        // Wait for transition to complete before hiding
        setTimeout(() => {
            if (!modal.classList.contains('show')) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }, 300);
    }
    
    // Form validation
    function validateForm() {
        let isValid = true;
        const form = document.getElementById('bookingForm');
        
        // Validate required fields
        form.querySelectorAll('[required]').forEach(field => {
            if (!field.value) {
                field.style.borderColor = '#D4AF37';
                field.style.boxShadow = '0 0 0 3px rgba(212, 175, 55, 0.2)';
                isValid = false;
            } else {
                field.style.borderColor = '';
                field.style.boxShadow = '';
            }
        });
        
        // Validate email format
        const email = form.querySelector('#email');
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
            email.style.borderColor = '#D4AF37';
            email.style.boxShadow = '0 0 0 3px rgba(212, 175, 55, 0.2)';
            isValid = false;
        }
        
        // Validate phone number
        const phone = form.querySelector('#phone');
        if (phone && phone.value.replace(/\D/g, '').length < 10) {
            phone.style.borderColor = '#D4AF37';
            phone.style.boxShadow = '0 0 0 3px rgba(212, 175, 55, 0.2)';
            isValid = false;
        }
        
        if (!isValid) {
            // Scroll to first error
            const firstError = document.querySelector('[style*="border-color: #D4AF37"]');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
        
        return isValid;
    }
    
    // Date and time handling
    const dateInput = document.getElementById('date');
    if (dateInput) {
        // Set minimum date to today
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const yyyy = today.getFullYear();
        dateInput.min = `${yyyy}-${mm}-${dd}`;
        
        dateInput.addEventListener('change', function() {
            updateAvailableTimes(this.value);
        });
    }
    
    async function updateAvailableTimes(date) {
        const timeSelect = document.getElementById('time');
        if (!timeSelect) return;
        
        timeSelect.innerHTML = '<option value="">Select a time</option>';
        
        if (!date) return;
        
        try {
            // Simulate API call to get booked times
            const response = await fetch(`get_booked_times.php?date=${date}`);
            const bookedTimes = await response.json();
            
            // Generate time slots from 9AM to 4PM
            const availableTimes = [];
            for (let hour = 9; hour <= 16; hour++) {
                availableTimes.push(`${hour}:00`);
            }
            
            // Filter available times
            availableTimes.forEach(time => {
                const bookingsCount = bookedTimes.filter(t => t.time === time).length;
                if (bookingsCount < 2) {
                    const option = document.createElement('option');
                    option.value = time;
                    option.textContent = time;
                    timeSelect.appendChild(option);
                }
            });
            
            // If no times available, show message
            if (timeSelect.options.length === 1) {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'No available time slots';
                option.disabled = true;
                timeSelect.appendChild(option);
            }
        } catch (error) {
            console.error('Error:', error);
            // Fallback - show all times
            for (let hour = 9; hour <= 16; hour++) {
                const option = document.createElement('option');
                option.value = `${hour}:00`;
                option.textContent = `${hour}:00`;
                timeSelect.appendChild(option);
            }
        }
    }
    
    // Handle URL parameters for success/error messages
    function handleUrlParams() {
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.has('booking') && urlParams.get('booking') === 'success') {
            const serviceId = urlParams.get('service');
            const date = urlParams.get('date');
            const time = urlParams.get('time');
            
            if (serviceId && date && time) {
                const serviceName = {
                    '1': 'Classic - 25,000 RWF',
                    '2': 'Hybrid - 30,000 RWF',
                    '3': 'Volume - 35,000 RWF',
                    '4': 'Mega Volume - 40,000 RWF'
                }[serviceId];
                
                document.getElementById('confirmationService').textContent = `Service: ${serviceName}`;
                document.getElementById('confirmationDate').textContent = `Date: ${new Date(date).toLocaleDateString()}`;
                document.getElementById('confirmationTime').textContent = `Time: ${time}`;
                
                openModal('confirmationModal');
            }
        }
        
        if (urlParams.has('error')) {
            const error = urlParams.get('error');
            let errorMessage = 'An error occurred. Please try again.';
            
            switch(error) {
                case 'time_slot_full':
                    errorMessage = 'The selected time slot is already booked. Please choose another time.';
                    break;
                case 'booking_failed':
                    errorMessage = 'Booking failed. Please try again or contact us.';
                    break;
                case 'db_error':
                    errorMessage = 'Database error. Please contact support.';
                    break;
            }
            
            const errorElement = document.createElement('div');
            errorElement.className = 'alert alert-danger';
            errorElement.textContent = errorMessage;
            
            const formHeader = document.querySelector('#bookingModal .modal-header');
            if (formHeader) {
                formHeader.after(errorElement);
            }
            
            openModal('bookingModal');
        }
    }
    
    handleUrlParams();
    
    // Quick contact form submission
    const quickContactForm = document.getElementById('quickContactForm');
    if (quickContactForm) {
        quickContactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;
            
            // Simulate form submission
            setTimeout(() => {
                submitBtn.innerHTML = '<i class="fas fa-check"></i> Sent!';
                
                // Reset form
                setTimeout(() => {
                    quickContactForm.reset();
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    
                    // Show success message
                    const successMsg = document.createElement('div');
                    successMsg.className = 'alert alert-success';
                    successMsg.textContent = 'Your message has been sent! We\'ll get back to you soon.';
                    quickContactForm.parentNode.insertBefore(successMsg, quickContactForm.nextSibling);
                    
                    // Remove message after 5 seconds
                    setTimeout(() => {
                        successMsg.remove();
                    }, 5000);
                }, 1000);
            }, 1500);
        });
    }
});
    </script>
</body>
</html>
<?php include 'includes/footer.php'; ?>
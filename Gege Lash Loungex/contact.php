<?php include 'includes/config.php'; ?>
<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="assets/css/style.css">
    <section class="contact-section">
        <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.490895534721!2d30.0582153153286!3d-1.9535375379990545!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwNTcnMTIuNyJTIDMwwrAwMyczNS4xIkU!5e0!3m2!1sen!2srw!4v1620000000000!5m2!1sen!2srw" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="contact-info">
            <h2 class="section-title">Contact Us</h2>
            <div class="info-item">
                <i class="fas fa-map-marker-alt"></i>
                <p><?php echo BUSINESS_LOCATION; ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-phone"></i>
                <p><?php echo BUSINESS_PHONE; ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-envelope"></i>
                <p><?php echo BUSINESS_EMAIL; ?></p>
            </div>
            <div class="info-item">
                <i class="fas fa-clock"></i>
                <p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed</p>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
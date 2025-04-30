<?php include 'includes/config.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/db.php'; ?>
<link rel="stylesheet" href="assets/css/style.css">
    <section class="services-section">
        <div class="container">
            <h2 class="section-title">Our Services</h2>
            <div class="services-grid">
                <?php
                $stmt = $pdo->query("SELECT * FROM services");
                while ($service = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                    <div class="service-card">
                        <div class="service-image" style="background-image: url(\'assets/images/services/' . strtolower(str_replace(' ', '-', $service['name'])) . '.jpg\');"></div>
                        <h3>' . $service['name'] . '</h3>
                        <p class="price">' . number_format($service['price']) . ' RWF</p>
                        <p>' . $service['description'] . '</p>
                        <a href="#" class="btn book-now-btn" data-service="' . $service['id'] . '">Book Now</a>
                    </div>';
                }
                ?>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
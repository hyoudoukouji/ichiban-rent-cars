<?php
session_start();
require_once __DIR__ . '/config/database.php';

// Fetch cars from database
$cars = [];
$featuredCar = null;
try {
    $result = $db->query('SELECT * FROM cars ORDER BY rating DESC LIMIT 1');
    $featuredCar = $result->fetchArray(SQLITE3_ASSOC);

    $result = $db->query('SELECT * FROM cars ORDER BY rating DESC LIMIT 6 OFFSET 1');
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $cars[] = $row;
    }
} catch (Exception $e) {
    // Handle query error gracefully
    $featuredCar = null;
    $cars = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ichiban Rent - Japanese Car Rentals</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EIC%3C/text%3E%3C/svg%3E" />
    <link rel="stylesheet" href="styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='40' height='40' fill='%231a1a1a'/%3E%3Ctext x='20' y='25' font-family='Arial' font-size='16' fill='white' text-anchor='middle'%3EIC%3C/text%3E%3C/svg%3E" alt="Logo" class="logo-img" />
                <span>Ichiban Rent</span>
            </div>
            <nav>
                <ul>
                    <li class="active"><i class="fas fa-home"></i> Home</li>
                    <li><i class="fas fa-compass"></i> Explore</li>
                    <li><i class="fas fa-heart"></i> Saved</li>
                    <li><i class="fas fa-car"></i> Rent</li>
                    <li><i class="fas fa-file-contract"></i> Terms & Conditions</li>
                    <li><i class="fas fa-user"></i> Profile</li>
                    <li><i class="fas fa-history"></i> Purchase History</li>
                    <li><i class="fas fa-cog"></i> Settings</li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <div class="header-content">
                    <h1>Japan Cars</h1>
                    <p>Experience the Heart of Japan in Every Drive.</p>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search Car ...." />
                    <button class="filter-btn"><i class="fas fa-sliders-h"></i></button>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile" />
                    </button>
                </div>
            </header>

            <!-- Featured Car -->
            <?php if ($featuredCar): ?>
            <section class="featured-car">
                <div class="car-details">
                    <h2><?= htmlspecialchars($featuredCar['name']) ?></h2>
                    <div class="rating">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fas fa-star"></i>
                        <?php endfor; ?>
                        <span>(2000+ Reviews)</span>
                    </div>
                    <p class="description">
                        <?= htmlspecialchars($featuredCar['engine']) ?>,
                        <?= htmlspecialchars($featuredCar['power']) ?>,
                        <?= htmlspecialchars($featuredCar['transmission']) ?>
                    </p>
                    <div class="price"><?= htmlspecialchars($featuredCar['price']) ?></div>
                    <div class="actions">
                        <div class="color-select">
                            <span>Color</span>
                            <div class="color-options">
                                <button class="color-btn white active"></button>
                                <button class="color-btn black"></button>
                            </div>
                        </div>
                        <div class="duration">
                            <button class="minus">-</button>
                            <span>1 Day</span>
                            <button class="plus">+</button>
                        </div>
                    </div>
                    <div class="rent-actions">
                        <button class="favorite-btn"><i class="far fa-heart"></i></button>
                        <button class="rent-btn">Rent now</button>
                    </div>
                </div>
                <div class="car-image">
                    <img src="<?= htmlspecialchars($featuredCar['image']) ?>" alt="<?= htmlspecialchars($featuredCar['name']) ?>" />
                </div>
            </section>
            <?php endif; ?>

            <!-- Car List -->
            <section class="car-list">
                <?php foreach ($cars as $car): ?>
                <div class="car-card">
                    <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['name']) ?>" />
                    <h3><?= htmlspecialchars($car['name']) ?></h3>
                    <div class="price"><?= htmlspecialchars($car['price']) ?></div>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <span><?= htmlspecialchars($car['rating']) ?></span>
                    </div>
                    <button class="add-btn">+</button>
                </div>
                <?php endforeach; ?>
            </section>

            <!-- Top Rent Section -->
            <section class="top-rent">
                <div class="section-header">
                    <h2>Top Rent</h2>
                    <a href="#" class="view-all">View all <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="top-rent-list">
                    <!-- Top rent items will be added here via JavaScript -->
                </div>
            </section>
        </main>
    </div>
    <script src="script.js"></script>
</body>
</html>

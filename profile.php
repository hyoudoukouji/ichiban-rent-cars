<?php
session_start();
require_once 'config/database.php';

// Simulated user data (replace with actual user data from database)
$user = [
    'id' => 1,
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
    'phone' => '+1234567890',
    'address' => '123 Street, City, Country',
    'joined_date' => '2023-01-01',
    'total_rentals' => 15,
    'preferred_cars' => ['Performance', 'JDM']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Ichiban Rent</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EIC%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .profile-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
            padding: 2rem;
        }

        .profile-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            background: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .profile-email {
            color: #666;
            margin-bottom: 1.5rem;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1a1a1a;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #666;
        }

        .profile-details {
            background: white;
            border-radius: 12px;
            padding: 2rem;
        }

        .details-section {
            margin-bottom: 2rem;
        }

        .details-section h2 {
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: #1a1a1a;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .detail-item {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .detail-label {
            font-size: 0.875rem;
            color: #666;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1rem;
            color: #1a1a1a;
        }

        .preferences {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .preference-tag {
            background: #1a1a1a;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }

        .edit-btn {
            background: #1a1a1a;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .edit-btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <img src="data:image/svg+xml,%3Csvg width='40' height='40' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='40' height='40' fill='%231a1a1a'/%3E%3Ctext x='20' y='25' font-family='Arial' font-size='16' fill='white' text-anchor='middle'%3EIC%3C/text%3E%3C/svg%3E" alt="Logo" class="logo-img">
                <span>Ichiban Rent</span>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="explore.php"><i class="fas fa-compass"></i> Explore</a></li>
                    <li><a href="saved.php"><i class="fas fa-heart"></i> Saved</a></li>
                    <li><a href="rent.php"><i class="fas fa-car"></i> Rent</a></li>
                    <li><a href="terms.php"><i class="fas fa-file-contract"></i> Terms & Conditions</a></li>
                    <li class="active"><i class="fas fa-user"></i> Profile</li>
                    <li><a href="history.php"><i class="fas fa-history"></i> Purchase History</a></li>
                    <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header>
                <div class="header-content">
                    <h1>Profile</h1>
                    <p>Manage your personal information and preferences.</p>
                </div>
                <div class="user-actions">
                    <button class="icon-btn"><i class="fas fa-envelope"></i></button>
                    <button class="icon-btn"><i class="fas fa-bell"></i></button>
                    <button class="profile-btn">
                        <img src="data:image/svg+xml,%3Csvg width='32' height='32' xmlns='http://www.w3.org/2000/svg'%3E%3Crect width='32' height='32' fill='%231a1a1a'/%3E%3Ctext x='16' y='20' font-family='Arial' font-size='14' fill='white' text-anchor='middle'%3EP%3C/text%3E%3C/svg%3E" alt="Profile">
                    </button>
                </div>
            </header>

            <div class="profile-content">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-avatar">
                        <?php echo substr($user['name'], 0, 1); ?>
                    </div>
                    <h2 class="profile-name"><?php echo htmlspecialchars($user['name']); ?></h2>
                    <p class="profile-email"><?php echo htmlspecialchars($user['email']); ?></p>
                    
                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-value"><?php echo $user['total_rentals']; ?></div>
                            <div class="stat-label">Total Rentals</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value"><?php echo count($user['preferred_cars']); ?></div>
                            <div class="stat-label">Preferences</div>
                        </div>
                    </div>

                    <button class="edit-btn">Edit Profile</button>
                </div>

                <!-- Profile Details -->
                <div class="profile-details">
                    <div class="details-section">
                        <h2>Personal Information</h2>
                        <div class="details-grid">
                            <div class="detail-item">
                                <div class="detail-label">Phone Number</div>
                                <div class="detail-value"><?php echo htmlspecialchars($user['phone']); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Address</div>
                                <div class="detail-value"><?php echo htmlspecialchars($user['address']); ?></div>
                            </div>
                            <div class="detail-item">
                                <div class="detail-label">Member Since</div>
                                <div class="detail-value"><?php echo date('F Y', strtotime($user['joined_date'])); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="details-section">
                        <h2>Car Preferences</h2>
                        <div class="preferences">
                            <?php foreach ($user['preferred_cars'] as $preference): ?>
                            <span class="preference-tag"><?php echo htmlspecialchars($preference); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.querySelector('.edit-btn').addEventListener('click', function() {
            alert('Profile editing functionality will be implemented soon!');
        });
    </script>
</body>
</html>

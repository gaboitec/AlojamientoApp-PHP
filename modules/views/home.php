<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AccommodationsAPP - Find Your Perfect Stay</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Plugins CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #0d6efd;
            --bs-body-font-family: 'DM Sans', sans-serif;
        }
        
        /* Header */
        .header-transparent {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        /* Hero section */
        .hero-section {
            background: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.3)), 
                        url('https://images.unsplash.com/photo-1566073771259-6a8506099945') center/cover;
            min-height: 600px;
            color: white;
            position: relative;
            padding-top: 160px;
        }

        /* Cards */
        .card {
            border: none;
            transition: all 0.3s;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        .card-img-wrapper {
            position: relative;
            padding-top: 66.67%; /* 3:2 Aspect Ratio */
            overflow: hidden;
        }

        .card-img-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .favorite-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255,255,255,0.9);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            z-index: 10;
        }

        .favorite-btn:hover {
            transform: scale(1.1);
            background: white;
        }

        .location-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .price-text {
            color: var(--primary-color);
            font-weight: 700;
        }

        /* Admin actions */
        .admin-actions {
            opacity: 0;
            transition: opacity 0.3s;
        }

        .card:hover .admin-actions {
            opacity: 1;
        }

        /* Dark theme overrides */
        [data-bs-theme="dark"] {
            --bs-body-bg: #0f0f10;
            --bs-body-color: #a1a1a8;
            --bs-border-color: #2a2a2a;
        }

        /* Search bar */
        .search-bar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 20px;
        }

        .search-input {
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .search-input:focus {
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border-color: var(--primary-color);
        }

        /* Avatar styles */
        .avatar {
            height: 40px;
            width: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Dropdown animation */
        .dropdown-animation {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <?php include './modules/views/components/navbarhome.php' ?>

    <!-- Hero Section -->
    <section class="position-relative py-8 py-lg-9" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945'); background-position: center; background-size: cover;">
        <!-- Background dark overlay -->
        <div class="bg-overlay bg-dark opacity-8"></div>
        <div class="container z-index-9 position-relative">
            <div class="row py-sm-5">
                <!-- Title -->
                <div class="col-xl-8 m-auto text-center">
                    <h6 class="text-white fw-normal mb-3">Discover & Connect With Great Places Around The World</h6>
                    <h1 class="display-4 text-white mb-4">Let's Discover
                        <span class="position-relative">Amazing Places
                            <!-- SVG decoration -->
                            <span class="position-absolute top-50 start-50 translate-middle z-index-n1 d-none d-md-block mt-4">
                                <svg width="390.5px" height="21.5px" viewBox="0 0 445.5 21.5">
                                    <path class="fill-primary opacity-7" d="M409.9,2.6c-9.7-0.6-19.5-1-29.2-1.5c-3.2-0.2-6.4-0.2-9.7-0.3..."></path>
                                </svg>
                            </span>
                        </span>
                    </h1>
                </div>

                <!-- Search START -->
                <div class="col-xl-10 mx-auto">
                    <div class="search-bar mt-5">
                        <form class="row g-3 justify-content-center align-items-center">
                            <div class="col-lg-5">
                                <input type="text" class="form-control search-input" placeholder="What are you looking for...">
                            </div>
                            <div class="col-lg-5">
                                <input type="text" class="form-control search-input" placeholder="Location">
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-primary w-100">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <!-- Title -->
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h2 class="mb-0">Great places to Explore</h2>
                    <p class="mb-0">Book your accommodation with us and don't forget to grab an awesome deal to save massive on your stay.</p>
                </div>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <?php if (!empty($accommodations)): 
                    foreach ($accommodations as $accommodation): 
                        $isFavorite = isset($userFavorites) && in_array($accommodation['id'], $userFavorites);
                ?>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card h-100">
                            <!-- Image wrapper -->
                            <div class="card-img-wrapper">
                                <img src="<?php echo htmlspecialchars($accommodation['image_url']); ?>" 
                                     class="card-img-top" alt="<?php echo htmlspecialchars($accommodation['name']); ?>">
                                
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <form action="./index.php?action=<?php echo $isFavorite ? 'removeFromFavorites' : 'addToFavorites'; ?>" 
                                          method="POST">
                                        <input type="hidden" name="accommodation_id" value="<?php echo $accommodation['id']; ?>">
                                        <button type="submit" class="favorite-btn" title="Toggle favorite">
                                            <i class="bi <?php echo $isFavorite ? 'bi-star-fill text-warning' : 'bi-star'; ?>"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>

                            <!-- Card body -->
                            <div class="card-body p-4">
                                <h5 class="card-title mb-1"><?php echo htmlspecialchars($accommodation['name']); ?></h5>
                                <p class="location-text mb-2">
                                    <i class="bi bi-geo-alt"></i> 
                                    <?php echo htmlspecialchars($accommodation['location']); ?>
                                </p>
                                <p class="card-text mb-3"><?php echo htmlspecialchars($accommodation['description']); ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="price-text mb-0">
                                        $<?php echo htmlspecialchars($accommodation['price']); ?> <small class="text-muted">/night</small>
                                    </p>
                                    
                                    <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                                        <div class="admin-actions">
                                            <a href="./index.php?view=updateAcomodation&id=<?php echo $accommodation['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary">Edit</a>
                                            <form action="./index.php?action=deleteAccommodation" method="POST" class="d-inline">
                                                <input type="hidden" name="id" value="<?php echo $accommodation['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Are you sure you want to delete this accommodation?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php 
                    endforeach; 
                else: 
                ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            No accommodations available at the moment.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Special Offers Section -->
    <section class="py-5">
        <div class="container">
            <div class="card bg-dark p-3">
                <div class="card-body border border-2 border-dashed border-white rounded position-relative">
                    <h2 class="text-white">Get an Extra 45% Discount Code</h2>
                    <div class="d-flex justify-content-between flex-wrap">
                        <h4 class="fw-light text-white mb-0">On all accommodations</h4>
                        <a href="#" class="text-warning fs-4">Use Code: BOOK45</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark py-7">
        <div class="container">
            <div class="row mx-auto">
                <div class="col-md-10 col-xl-6 mx-auto text-center">
                    <h3 class="text-white mb-3">AccommodationsAPP</h3>
                    <p class="text-white-50">Find your perfect stay with us.</p>
                    <div class="text-white-50 mt-3">© 2024 AccommodationsAPP. All rights reserved.</div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

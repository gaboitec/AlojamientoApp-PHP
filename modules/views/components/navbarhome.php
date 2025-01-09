<header class="header-transparent">
    <nav class="navbar navbar-dark navbar-expand-xl">
        <div class="container">
            <!-- Logo START -->
            <a class="navbar-brand" href="./index.php">
                <h3 class="text-white mb-0">AccommodationsAPP</h3>
            </a>
            <!-- Logo END -->

            <!-- Responsive navbar toggler -->
            <button class="navbar-toggler ms-auto me-3 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-animation">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <!-- Main navbar START -->
            <div class="navbar-collapse collapse" id="navbarCollapse">
                <ul class="navbar-nav navbar-nav-scroll mx-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="./index.php">Home</a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="./index.php?view=showAcomodations">Accommodations</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="./index.php?view=showUsers">Users</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- Main navbar END -->

            <!-- Profile dropdown START -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="nav-item ms-3 dropdown">
                    <!-- Avatar -->
                    <a class="avatar avatar-sm p-0" href="#" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
                        <img class="avatar-img rounded-2" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['username']); ?>&background=random" alt="avatar">
                    </a>

                    <ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3" aria-labelledby="profileDropdown">
                        <!-- Profile info -->
                        <li class="px-3 mb-3">
                            <div class="d-flex align-items-center">
                                <!-- Avatar -->
                                <div class="avatar me-3">
                                    <img class="avatar-img rounded-circle shadow" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['username']); ?>&background=random" alt="avatar">
                                </div>
                                <div>
                                    <a class="h6 mt-2 mt-sm-0" href="#"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                                    <p class="small m-0">Role: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
                                </div>
                            </div>
                        </li>

                        <!-- Links -->
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="./index.php?view=profile">
                                <i class="bi bi-person fa-fw me-2"></i>My Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="./index.php?view=profile">
                                <i class="bi bi-heart fa-fw me-2"></i>My Favorites
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item bg-danger-soft-hover" href="./index.php?action=logout">
                                <i class="bi bi-power fa-fw me-2"></i>Sign Out
                            </a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="nav-item ms-3">
                    <a href="./index.php?view=login" class="btn btn-sm btn-white mb-0">Sign In</a>
                    <a href="./index.php?view=register" class="btn btn-sm btn-primary mb-0">Sign Up</a>
                </div>
            <?php endif; ?>
            <!-- Profile dropdown END -->
        </div>
    </nav>
</header>
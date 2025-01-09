<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">AccommodationsAPP</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?view=showAcomodations">Accommodations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?view=showUsers">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php?view=profile">My Profile</a>
                </li>
            </ul>
            <span class="navbar-text me-3">
                Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
            </span>
            <a href="./index.php?action=logout" class="btn btn-outline-danger">Logout</a>
        </div>
    </div>
</nav>
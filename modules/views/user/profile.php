<?php
if (!isset($_SESSION['user_id'])) {
    header('Location: ./index.php?view=login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mi Perfil</title>
</head>
<body>
    <?php 
    // Mostrar el navbar según el rol
    if ($_SESSION['role'] === 'admin') {
        include './modules/views/components/navbaradmin.php';
    } else {
        include './modules/views/components/navbarhome.php';
    }
    ?>
    
    <div class="container mt-5">
        <div class="row">
            <!-- Perfil del Usuario -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>My Profile</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($success)): ?>
                            <div class="alert alert-success">
                                <?php echo htmlspecialchars($success); ?>
                            </div>
                        <?php endif; ?>

                        <form action="./index.php?action=updateProfile" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Alojamientos Favoritos -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>My Favorite Accommodations</h3>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($favorites)): ?>
                            <div class="row">
                                <?php foreach ($favorites as $accommodation): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100">
                                            <img src="<?php echo htmlspecialchars($accommodation['image_url']); ?>" 
                                                 class="card-img-top" alt="<?php echo htmlspecialchars($accommodation['name']); ?>">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo htmlspecialchars($accommodation['name']); ?></h5>
                                                <p class="card-text"><?php echo htmlspecialchars($accommodation['description']); ?></p>
                                                <p class="card-text">
                                                    <strong>Ubicación:</strong> <?php echo htmlspecialchars($accommodation['location']); ?><br>
                                                    <strong>Precio:</strong> $<?php echo htmlspecialchars($accommodation['price']); ?>
                                                </p>
                                                <form action="./index.php?action=removeFromFavorites" method="POST">
                                                    <input type="hidden" name="accommodation_id" 
                                                           value="<?php echo $accommodation['id']; ?>">
                                                    <button type="submit" class="btn btn-danger">Eliminar de Favoritos</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                No tienes alojamientos favoritos aún.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
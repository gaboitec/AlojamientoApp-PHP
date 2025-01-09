<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
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
    <title>Accommodations List</title>
</head>
<body>
    <?php include './modules/views/components/navbaradmin.php' ?>
    
    <div class="container mt-5">
        <h2>All Accommodations</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                Operation completed successfully.
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <?php if (isset($accommodations) && is_array($accommodations) && !empty($accommodations)): ?>
                <?php foreach ($accommodations as $accommodation): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($accommodation['image_url']); ?>" 
                                 class="card-img-top" alt="<?php echo htmlspecialchars($accommodation['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($accommodation['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($accommodation['description']); ?></p>
                                <p class="card-text">
                                    <strong>Location:</strong> <?php echo htmlspecialchars($accommodation['location']); ?><br>
                                    <strong>Price:</strong> $<?php echo htmlspecialchars($accommodation['price']); ?>
                                </p>
                                <div class="btn-group">
                                    <a href="./index.php?view=updateAcomodation&id=<?php echo $accommodation['id']; ?>" 
                                       class="btn btn-primary">Edit</a>
                                    <form action="./index.php?action=deleteAccommodation" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $accommodation['id']; ?>">
                                        <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this accommodation?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No accommodations available.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
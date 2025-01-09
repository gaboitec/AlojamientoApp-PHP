<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger">
            <h4>An error occurred</h4>
            <?php if (isset($e)): ?>
                <p><?php echo htmlspecialchars($e->getMessage()); ?></p>
            <?php else: ?>
                <p>Something went wrong. Please try again later.</p>
            <?php endif; ?>
            <a href="index.php" class="btn btn-primary">Go Home</a>
        </div>
    </div>
</body>
</html> 
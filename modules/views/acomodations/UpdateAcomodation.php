<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ./index.php?view=login');
    exit();
}

if (!isset($accommodation)) {
    header('Location: ./index.php?view=showAcomodations');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Update Accommodation</title>
</head>
<body>
    <?php include './modules/views/components/navbaradmin.php' ?>
    
    <div class="container mt-5">
        <h2>Update Accommodation</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form class="row g-3" action="./index.php?action=update" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($accommodation['id']); ?>">
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($accommodation['image_url']); ?>">
            
            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" 
                       value="<?php echo htmlspecialchars($accommodation['name']); ?>" required>
            </div>

            <div class="col-md-6">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" 
                       value="<?php echo htmlspecialchars($accommodation['location']); ?>" required>
            </div>

            <div class="col-md-6">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="precio" name="precio" 
                       value="<?php echo htmlspecialchars($accommodation['price']); ?>" required>
            </div>
            
            <div class="col-md-6">
                <label for="imagen" class="form-label">Nueva Imagen (opcional)</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                <?php if (!empty($accommodation['image_url'])): ?>
                    <div class="mt-2">
                        <small>Imagen actual:</small><br>
                        <img src="<?php echo htmlspecialchars($accommodation['image_url']); ?>" 
                             alt="Current image" style="max-width: 200px;" class="img-thumbnail">
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-12">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required><?php 
                    echo htmlspecialchars($accommodation['description']); 
                ?></textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="./index.php?view=showAcomodations" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

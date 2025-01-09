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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Ingresa un nuevo Alojamiento</title>
</head>
<body>
    <?php include './modules/views/components/navbar.php'?>
    <div class="container mt-3">
        <?php include './modules/views/components/messages.php'; ?>
    </div>
    <h2 class="text-center mt-2">Agregar un nuevo alojamiento</h2>
    <main class="container mt-2">
        <section>
        <form class="row g-3" action="./index.php?action=create" method="POST" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>

                <div class="col-md-6">
                    <label for="ubicacion" class="form-label">Ubicacion</label>
                    <input type="text" class="form-control" id="ubicacion" name="ubicacion">
                </div>

                <div class="col-md-6">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio">
                </div>
                
                <div class="col-md-6">
                    <label for="descuento" class="form-label">Imagen</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                </div>

                <div class="col-md-6">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <textarea type="text" class="form-control" id="descripcion" name="descripcion"></textarea>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Agregar</button>
                </div>
            </form>
        </section>
    </main>
    <?php include './modules/views/components/footer.php' ?>
</body>
</html>
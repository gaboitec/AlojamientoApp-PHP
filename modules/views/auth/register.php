<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
<?php include './modules/views/components/navbar.php'?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <h4 class="text-center mb-4 card-header">Crear una Cuenta</h4>
                    <div class="card-body">
                        <form action="registerAuth.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                        </form>
                    </div>
                    <div class="card-footer">
                        <p>Si ya tienes cuenta puedes <a href="./index.php?view=login">iniciar sessión</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Registro de Usuario</h1>
    <form id="register">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required>
        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Registrar</button>
    </form>
    <button onclick="goBack()">Volver Atrás</button>

    <script>
        function goBack() {
            window.history.back();
        }

        document.getElementById('register').onsubmit = function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append('action', 'register');

            fetch('auth.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    window.location.href = 'index.html'; // Redirección a index.html después del registro
                } else {
                    alert(data.error);
                }
            });
        };
    </script>
</body>
</html>

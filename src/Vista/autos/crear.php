<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Auto</title>
</head>

<body>
    <h2>Registrar Nuevo Auto</h2>

    <form action="<?= BASE_URL_CTRL ?>auto/guardar_controller.php" method="POST">
        <div>
            <label for="patente">Patente:</label>
            <input
                type="text"
                id="patente"
                name="patente"
                maxlength="7"
                required
                placeholder="Ej: ABC1234">
        </div>

        <div>
            <label for="marca">Marca:</label>
            <input
                type="text"
                id="marca"
                name="marca"
                required
                placeholder="Ej: Toyota">
        </div>

        <div>
            <label for="modelo">Modelo:</label>
            <input
                type="text"
                id="modelo"
                name="modelo"
                required
                placeholder="Ej: Corolla">
        </div>

        <div>
            <label for="estado">Estado:</label>
            <select
                id="estado"
                name="estado"
                required>
                <option value="disponible" selected>Disponible</option>
                <option value="reservado">Reservado</option>
                <option value="vendido">Vendido</option>
            </select>
        </div>


        <div>
            <button type="submit">
                Registrar Auto
            </button>
        </div>
    </form>
</body>

</html>
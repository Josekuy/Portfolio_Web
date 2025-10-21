<?php
$conexion = new mysqli("localhost", "root", "", "portfolio_db");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener proyectos de branding
$resultado = $conexion->query("SELECT * FROM branding_projects ORDER BY id DESC");

while ($fila = $resultado->fetch_assoc()) {
    $title = htmlspecialchars($fila['title'], ENT_QUOTES, 'UTF-8');
    $desc = htmlspecialchars($fila['description'], ENT_QUOTES, 'UTF-8');
    $logo = htmlspecialchars($fila['logo_image'], ENT_QUOTES, 'UTF-8');

    // Aseguramos que el JSON esté correctamente formateado
    $apps = json_decode($fila['applications'] ?? '[]', true);
    if (!is_array($apps)) {
        $apps = [];
    }

    // Convertimos nuevamente a JSON limpio (sin comillas escapadas)
    $apps_json = json_encode($apps, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    echo "
    <div class='swiper-slide branding-item'
         data-id='{$fila['id']}'
         data-title='{$title}'
         data-description='{$desc}'>
        <img src='{$logo}' alt='{$title}'>
        <script type='application/json' class='apps-data'>{$apps_json}</script>
    </div>";
}

$conexion->close();
?>


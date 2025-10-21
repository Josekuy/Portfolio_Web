<?php
function mostrar_grid($categoria = 'diseno') {
    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "", "portfolio_db");
    if ($conexion->connect_error) die("Conexión fallida: " . $conexion->connect_error);

    // Categorías válidas
    $categorias_validas = ['diseno', 'branding', 'ilustracion', 'fotografia'];
    if (!in_array($categoria, $categorias_validas)) $categoria = 'diseno';

    // Consulta segura con orden
    $stmt = $conexion->prepare("SELECT titulo, ruta_imagen FROM grids WHERE categoria = ? ORDER BY orden ASC");
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Generar grid
    while ($fila = $resultado->fetch_assoc()) {
        echo '<div class="portfolio-item">';
        echo '<img src="'.$fila['ruta_imagen'].'" alt="'.$fila['titulo'].'">';
        echo '<p class="portfolio-item__title">'.$fila['titulo'].'</p>';
        echo '</div>';
    }

    $stmt->close();
    $conexion->close();
}
?>


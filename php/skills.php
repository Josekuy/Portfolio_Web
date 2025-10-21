<?php
$conexion = new mysqli("localhost", "root", "", "portfolio_db");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$resultado = $conexion->query("SELECT * FROM skills ORDER BY id ASC");

if ($resultado->num_rows > 0) {
    while($fila = $resultado->fetch_assoc()) {
        echo '<div class="about-section__skill-item">';
        echo '<img src="'.$fila['icono'].'" alt="'.$fila['nombre'].'" class="skill-icon">';
        echo '<div class="about-section__skill-bar">';
        echo '<div class="about-section__skill-level" data-width="'.$fila['nivel'].'%"></div>';
        echo '</div>';
        echo '</div>';
    }
}

$conexion->close();
?>
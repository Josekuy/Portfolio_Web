<?php
$conexion = new mysqli("localhost", "root", "", "portfolio_db");
$resultado = $conexion->query("SELECT * FROM fotos_slider");

while($fila = $resultado->fetch_assoc()) {
    echo '<div class="swiper-slide">';
    echo '<img src="'.$fila['ruta_imagen'].'" alt="'.$fila['titulo'].'">';
    echo '</div>';
}
?>
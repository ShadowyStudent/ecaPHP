<?php

/* 
includes/menu.php
Menú de navegación reutilizable:
- Lista de enlaces a las secciones y páginas del proyecto.
- Incluir con include/require en cada página para mantener consistencia.
*/

$current = basename($_SERVER['SCRIPT_NAME']);
?>
<nav class="site-nav">
  <ul>
    <li><a href="index.php" class="<?= $current === 'index.php' ? 'active' : '' ?>">Inicio</a></li>
    <li><a href="condicionales.php" class="<?= $current === 'condicionales.php' ? 'active' : '' ?>">Condicionales</a></li>
    <li><a href="bucles.php" class="<?= $current === 'bucles.php' ? 'active' : '' ?>">Bucles</a></li>
    <li><a href="arreglos.php" class="<?= $current === 'arreglos.php' ? 'active' : '' ?>">Arreglos</a></li>
  </ul>
</nav>
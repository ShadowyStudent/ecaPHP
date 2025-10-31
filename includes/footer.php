<?php 

/* 
includes/footer.php
Pie de página compartido:
- Scripts comunes (por ejemplo JS de Bootstrap).
- Cierre de contenedores HTML y elementos comunes al final de cada página.
*/

if (session_status() === PHP_SESSION_NONE) session_start(); 
?>
<footer class="site-footer">
  <div class="container">
    <p>&copy; <?= date('Y') ?> - Proyecto ecaPHP</p>
    <p>Visitas en esta sesión: <strong><?= htmlspecialchars($_SESSION['visitas'] ?? 0, ENT_QUOTES, 'UTF-8') ?></strong></p>
    <p>Autor: <strong>Miguel Álvarez López</strong></p>
  </div>
</footer>
</body>
</html>

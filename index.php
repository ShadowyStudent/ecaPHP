<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/header.php';
require_once 'includes/menu.php';
?>
<main class="container my-4">
  <section class="mb-4">
    <h2>Bienvenido</h2>
    <?php
    echo "<p>Hola. Bienvenido al proyecto <strong>ecaPHP</strong>.</p>";
    echo "<p>Hoy es: <strong>" . date('d/m/Y') . "</strong></p>";
    $items = ['condicionales', 'bucles', 'arreglos'];
    echo "<p>Secciones disponibles: <strong>" . count($items) . "</strong></p>";
    ?>
  </section>

  <section>
    <h3>Sobre la página</h3>
    <p>ecaPHP demuestra el uso de estructuras de control y arreglos en PHP mediante ejemplos claros y archivos reutilizables.</p>
    <span class="badge bg-primary">Proyecto: ecaPHP</span>
  </section>
</main>
<?php require_once 'includes/footer.php'; ?>
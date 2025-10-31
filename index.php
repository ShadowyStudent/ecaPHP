<?php
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/menu.php';
if (!isset($_SESSION['visitas'])) $_SESSION['visitas'] = 0;
$_SESSION['visitas']++;
?>
<main class="container">
  <section>
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
    <p class="badge">Proyecto: ecaPHP</p>
  </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>

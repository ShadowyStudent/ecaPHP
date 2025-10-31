<?php

/* 
condicionales.php
Demuestra estructuras de decisión:
- if / elseif / else para evaluar valores y controlar flujo.
- switch para seleccionar acciones según casos.
- Aplica condicionales sobre variables y elementos de arreglos para mostrar resultados dinámicos.
*/

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/menu.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['cond_usuarios'])) {
    $_SESSION['cond_usuarios'] = [
        ['nombre' => 'Ana', 'edad' => 17],
        ['nombre' => 'Luis', 'edad' => 22],
        ['nombre' => 'María', 'edad' => 15],
        ['nombre' => 'Carlos', 'edad' => 30],
    ];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'agregar') {
        $nombre = trim($_POST['nombre'] ?? '');
        $edad = isset($_POST['edad']) && is_numeric($_POST['edad']) ? (int) $_POST['edad'] : null;
        if ($nombre !== '' && $edad !== null) {
            $_SESSION['cond_usuarios'][] = ['nombre' => $nombre, 'edad' => $edad];
        }
    }
    if (isset($_POST['accion']) && $_POST['accion'] === 'limpiar') {
        $_SESSION['cond_usuarios'] = [];
    }
}
$nota = isset($_GET['nota']) && is_numeric($_GET['nota']) ? (int) $_GET['nota'] : 7;
$diaNumero = isset($_GET['dia']) && is_numeric($_GET['dia']) ? (int) $_GET['dia'] : (int) date('N');
$usuarios = $_SESSION['cond_usuarios'];
?>
<main class="container">
    <h2>Condicionales</h2>

    <section>
        <h3>Probar nota</h3>
        <p class="subtitle">Cambia la nota para ver cómo if/elseif/else eligen una etiqueta.</p>
        <form method="get" action="condicionales.php">
            <label for="nota">Nota:</label>
            <input id="nota" name="nota" type="number" min="0" max="10" value="<?= htmlspecialchars($nota, ENT_QUOTES, 'UTF-8') ?>" />
            <button type="submit">Evaluar</button>
        </form>
        <?php
        echo "<h4>Resultado</h4>";
        if ($nota >= 9) {
            echo "<p>Calificación: <strong>Excelente</strong> (nota = {$nota})</p>";
        } elseif ($nota >= 7) {
            echo "<p>Calificación: <strong>Bien</strong> (nota = {$nota})</p>";
        } elseif ($nota >= 5) {
            echo "<p>Calificación: <strong>Suficiente</strong> (nota = {$nota})</p>";
        } else {
            echo "<p>Calificación: <strong>Insuficiente</strong> (nota = {$nota})</p>";
        }
        ?>
    </section>

    <section>
        <h3>Probar switch (día)</h3>
        <p class="subtitle">Selecciona un número 1–7 para ver qué caso toma switch.</p>
        <form method="get" action="condicionales.php">
            <label for="dia">Día (1=Lun ... 7=Dom):</label>
            <select id="dia" name="dia">
                <?php for ($d = 1; $d <= 7; $d++): ?>
                    <option value="<?= $d ?>" <?= $d === $diaNumero ? 'selected' : '' ?>><?= $d ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit">Ver</button>
        </form>
        <?php
        echo "<h4>Resultado</h4>";
        switch ($diaNumero) {
            case 6:
            case 7:
                echo "<p>Hoy es fin de semana (día = {$diaNumero}).</p>";
                break;
            case 1:
                echo "<p>Hoy es lunes (día = {$diaNumero}). ¡Comienza la semana!</p>";
                break;
            case 5:
                echo "<p>Hoy es viernes (día = {$diaNumero}). Casi fin de semana.</p>";
                break;
            default:
                echo "<p>Hoy es día de semana (día = {$diaNumero}).</p>";
                break;
        }
        ?>
    </section>

    <section>
        <h3>Usuarios y clasificación</h3>
        <p class="subtitle">Agrega usuarios y observa la clasificación Adulto/Menor en el recorrido del arreglo.</p>
        <form method="post" action="condicionales.php">
            <input type="hidden" name="accion" value="agregar" />
            <label for="nombre">Nombre:</label>
            <input id="nombre" name="nombre" type="text" required />
            <label for="edad">Edad:</label>
            <input id="edad" name="edad" type="number" min="0" required />
            <button type="submit">Agregar usuario</button>
        </form>

        <form method="post" action="condicionales.php" style="margin-top:8px;">
            <input type="hidden" name="accion" value="limpiar" />
            <button type="submit">Limpiar usuarios</button>
        </form>

        <?php
        if (empty($usuarios)) {
            echo "<p>No hay usuarios registrados.</p>";
        } else {
            echo "<ul>";
            foreach ($usuarios as $u) {
                $estado = ($u['edad'] >= 18) ? 'Adulto' : 'Menor';
                echo "<li>" . htmlspecialchars($u['nombre'], ENT_QUOTES, 'UTF-8') . " - " . (int) $u['edad'] . " años — <strong>" . $estado . "</strong></li>";
            }
            echo "</ul>";
        }
        ?>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
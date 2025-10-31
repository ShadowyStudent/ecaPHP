<?php

/* 
bucles.php
Contiene ejemplos de iteración:
- for para iteraciones con contador.
- while para repeticiones condicionadas.
- foreach para recorrer colecciones de forma segura.
- Muestra cómo combinar bucles y condicionales para procesar y presentar datos.
*/

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/menu.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['secuencia_texto'])) $_SESSION['secuencia_texto'] = "Paso 1\nPaso 2\nPaso 3";
if (!isset($_SESSION['foreach_tareas'])) {
    $_SESSION['foreach_tareas'] = [
        ['texto' => 'Leer documentación', 'hecha' => false],
        ['texto' => 'Practicar ejercicios', 'hecha' => true],
        ['texto' => 'Enviar reporte', 'hecha' => false],
    ];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion'])) {
        if ($_POST['accion'] === 'guardar_secuencia') {
            $_SESSION['secuencia_texto'] = rtrim($_POST['secuencia_texto'] ?? '');
        }
        if ($_POST['accion'] === 'agregar_tarea') {
            $t = trim($_POST['tarea'] ?? '');
            if ($t !== '') $_SESSION['foreach_tareas'][] = ['texto' => $t, 'hecha' => false];
        }
        if ($_POST['accion'] === 'toggle_tarea' && isset($_POST['idx'])) {
            $i = (int)$_POST['idx'];
            if (array_key_exists($i, $_SESSION['foreach_tareas'])) {
                $_SESSION['foreach_tareas'][$i]['hecha'] = !$_SESSION['foreach_tareas'][$i]['hecha'];
            }
        }
        if ($_POST['accion'] === 'remover_tarea' && isset($_POST['idx'])) {
            $i = (int)$_POST['idx'];
            if (array_key_exists($i, $_SESSION['foreach_tareas'])) array_splice($_SESSION['foreach_tareas'], $i, 1);
        }
        if ($_POST['accion'] === 'limpiar_tareas') $_SESSION['foreach_tareas'] = [];
    }
    header('Location: bucles.php');
    exit;
}
$forCount = isset($_GET['forCount']) && is_numeric($_GET['forCount']) ? max(0, (int)$_GET['forCount']) : 5;
$whileStart = isset($_GET['whileStart']) && is_numeric($_GET['whileStart']) ? (int)$_GET['whileStart'] : 3;
$secuencia = $_SESSION['secuencia_texto'];
$tareas = &$_SESSION['foreach_tareas'];
?>
<main class="container">
    <h2>Bucles</h2>

    <section>
        <h3>For</h3>
        <p class="subtitle">Muestra iteraciones 1..N con for.</p>
        <form method="get" action="bucles.php">
            <label for="forCount">Iteraciones:</label>
            <input id="forCount" name="forCount" type="number" min="0" value="<?= htmlspecialchars($forCount, ENT_QUOTES, 'UTF-8') ?>" />
            <button type="submit">Ejecutar</button>
        </form>
        <h4>Resultado</h4>
        <ul>
            <?php for ($i = 1; $i <= $forCount; $i++): ?>
                <li>Iteración <?= $i ?></li>
            <?php endfor; ?>
        </ul>
    </section>

    <section>
        <h3>While</h3>
        <p class="subtitle">Cuenta regresiva desde un valor inicial usando while.</p>
        <form method="get" action="bucles.php">
            <label for="whileStart">Valor inicial:</label>
            <input id="whileStart" name="whileStart" type="number" value="<?= htmlspecialchars($whileStart, ENT_QUOTES, 'UTF-8') ?>" />
            <button type="submit">Ejecutar</button>
        </form>
        <h4>Resultado</h4>
        <ul>
            <?php
            $n = $whileStart;
            if ($whileStart > 0) {
                while ($n > 0) {
                    echo '<li>Cuenta regresiva: ' . (int)$n . '</li>';
                    $n--;
                }
            } else {
                echo '<li>Valor inicial debe ser mayor que 0</li>';
            }
            ?>
        </ul>
    </section>

    <section id="foreach">
        <h3>Foreach</h3>
        <p class="subtitle">Recorre lista de tareas y permite marcar, eliminar o añadir.</p>
        <form method="post" action="bucles.php#foreach">
            <input type="hidden" name="accion" value="agregar_tarea" />
            <label for="tarea">Nueva tarea:</label>
            <input id="tarea" name="tarea" type="text" />
            <button type="submit">Agregar</button>
            <button type="submit" formaction="bucles.php#foreach" formmethod="post" name="accion" value="limpiar_tareas">Vaciar tareas</button>
        </form>

        <?php if (empty($tareas)): ?>
            <p>No hay tareas.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($tareas as $i => $t): ?>
                    <li>
                        <strong><?= htmlspecialchars($t['texto'], ENT_QUOTES, 'UTF-8') ?></strong>
                        <?php if ($t['hecha']): ?>
                            <span style="color:green">[Hecha]</span>
                        <?php else: ?>
                            <span style="color:#b87a00">[Pendiente]</span>
                        <?php endif; ?>
                        <form method="post" action="bucles.php#foreach" style="display:inline">
                            <input type="hidden" name="accion" value="toggle_tarea" />
                            <input type="hidden" name="idx" value="<?= (int)$i ?>" />
                            <button type="submit"><?= $t['hecha'] ? 'Marcar pendiente' : 'Marcar hecha' ?></button>
                        </form>
                        <form method="post" action="bucles.php#foreach" style="display:inline">
                            <input type="hidden" name="accion" value="remover_tarea" />
                            <input type="hidden" name="idx" value="<?= (int)$i ?>" />
                            <button type="submit">Eliminar</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
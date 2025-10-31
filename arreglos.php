<?php

/* 
arreglos.php
Ejemplos de manejo de arreglos:
- Arreglo indexado: declaración, acceso por índice y recorrido.
- Arreglo asociativo: pares clave => valor, acceso por clave y manipulación.
- Arreglo multidimensional: lista de productos con nombre y precio; recorrido y condicionales para clasificación.
- Demuestra persistencia en sesión y operaciones básicas (agregar, eliminar, vaciar).
*/

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/menu.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['arr_indexado'])) $_SESSION['arr_indexado'] = ['Manzana', 'Banana', 'Cereza'];
if (!isset($_SESSION['arr_asociativo'])) $_SESSION['arr_asociativo'] = ['nombre' => 'Carlos', 'edad' => 28, 'ciudad' => 'CDMX'];
if (!isset($_SESSION['arr_productos'])) $_SESSION['arr_productos'] = [
    ['nombre' => 'Camiseta', 'precio' => 199.99],
    ['nombre' => 'Taza', 'precio' => 59.50],
    ['nombre' => 'Cuaderno', 'precio' => 89.00],
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion === 'agregar_index') {
            $v = trim($_POST['valor_index'] ?? '');
            if ($v !== '') $_SESSION['arr_indexado'][] = $v;
        } elseif ($accion === 'limpiar_index') {
            $_SESSION['arr_indexado'] = [];
        } elseif ($accion === 'agregar_asoc') {
            $k = trim($_POST['clave_asoc'] ?? '');
            $v = trim($_POST['valor_asoc'] ?? '');
            if ($k !== '' && $v !== '') $_SESSION['arr_asociativo'][$k] = $v;
        } elseif ($accion === 'remover_asoc' && isset($_POST['clave'])) {
            $k = $_POST['clave'];
            unset($_SESSION['arr_asociativo'][$k]);
        } elseif ($accion === 'limpiar_asoc') {
            $_SESSION['arr_asociativo'] = [];
        } elseif ($accion === 'agregar_prod') {
            $n = trim($_POST['prod_nombre'] ?? '');
            $p = isset($_POST['prod_precio']) && is_numeric($_POST['prod_precio']) ? (float) $_POST['prod_precio'] : null;
            if ($n !== '' && $p !== null) $_SESSION['arr_productos'][] = ['nombre' => $n, 'precio' => $p];
        } elseif ($accion === 'remover_prod' && isset($_POST['idx'])) {
            $idx = (int)$_POST['idx'];
            if (array_key_exists($idx, $_SESSION['arr_productos'])) array_splice($_SESSION['arr_productos'], $idx, 1);
        } elseif ($accion === 'limpiar_productos') {
            $_SESSION['arr_productos'] = [];
        }
    }
    header('Location: arreglos.php');
    exit;
}
$indexado = $_SESSION['arr_indexado'];
$asociativo = $_SESSION['arr_asociativo'];
$productos = $_SESSION['arr_productos'];
?>
<main class="container">
    <h2>Arreglos</h2>

    <section>
        <h3>Arreglo indexado</h3>
        <p class="subtitle">Lista simple; recorrido con for usando índices. Operaciones: agregar y vaciar.</p>
        <form method="post" action="arreglos.php">
            <input type="hidden" name="accion" value="agregar_index" />
            <label for="valor_index">Elemento</label>
            <input id="valor_index" name="valor_index" type="text" />
            <button type="submit">Agregar</button>
            <button type="submit" formaction="arreglos.php" formmethod="post" name="accion" value="limpiar_index">Vaciar</button>
        </form>
        <?php $c = count($indexado); if ($c === 0): ?>
            <p>No hay elementos en el arreglo indexado.</p>
        <?php else: ?>
            <ol>
                <?php for ($i = 0; $i < $c; $i++): ?>
                    <li><?= htmlspecialchars($indexado[$i], ENT_QUOTES, 'UTF-8') ?></li>
                <?php endfor; ?>
            </ol>
        <?php endif; ?>
    </section>

    <section>
        <h3>Arreglo asociativo</h3>
        <p class="subtitle">Par clave => valor; uso de foreach para mostrar pares y acciones por clave.</p>
        <form method="post" action="arreglos.php">
            <input type="hidden" name="accion" value="agregar_asoc" />
            <label for="clave_asoc">Clave</label>
            <input id="clave_asoc" name="clave_asoc" type="text" />
            <label for="valor_asoc">Valor</label>
            <input id="valor_asoc" name="valor_asoc" type="text" />
            <button type="submit">Agregar / Modificar</button>
            <button type="submit" formaction="arreglos.php" formmethod="post" name="accion" value="limpiar_asoc">Vaciar asociativo</button>
        </form>
        <?php if (empty($asociativo)): ?>
            <p>No hay pares en el arreglo asociativo.</p>
        <?php else: ?>
            <table class="tabla-productos">
                <thead><tr><th>Clave</th><th>Valor</th><th></th></tr></thead>
                <tbody>
                    <?php foreach ($asociativo as $k => $v): ?>
                        <tr>
                            <td><?= htmlspecialchars($k, ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($v, ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <form method="post" action="arreglos.php" style="display:inline">
                                    <input type="hidden" name="accion" value="remover_asoc" />
                                    <input type="hidden" name="clave" value="<?= htmlspecialchars($k, ENT_QUOTES, 'UTF-8') ?>" />
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>

    <section>
        <h3>Arreglo multidimensional (productos)</h3>
        <p class="subtitle">Tabla de productos; recorrido con for; condicionales asignan clase por rango de precio.</p>
        <form method="post" action="arreglos.php">
            <input type="hidden" name="accion" value="agregar_prod" />
            <label for="prod_nombre">Nombre</label>
            <input id="prod_nombre" name="prod_nombre" type="text" />
            <label for="prod_precio">Precio</label>
            <input id="prod_precio" name="prod_precio" type="number" step="0.01" min="0" />
            <button type="submit">Agregar producto</button>
            <button type="submit" formaction="arreglos.php" formmethod="post" name="accion" value="limpiar_productos">Vaciar productos</button>
        </form>
        <?php $pcount = count($productos); if ($pcount === 0): ?>
            <p>No hay productos.</p>
        <?php else: ?>
            <table class="tabla-productos">
                <thead><tr><th>#</th><th>Producto</th><th>Precio</th><th></th></tr></thead>
                <tbody>
                    <?php for ($i = 0; $i < $pcount; $i++):
                        $p = $productos[$i];
                        $precio = isset($p['precio']) ? (float)$p['precio'] : 0.0;
                        if ($precio > 100.0) {
                            $clase = 'caro-strong';
                        } elseif ($precio >= 50.0) {
                            $clase = 'medio-strong';
                        } else {
                            $clase = 'barato-strong';
                        }
                    ?>
                        <tr class="<?= $clase ?>">
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($p['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td>$<?= number_format($precio, 2) ?></td>
                            <td>
                                <form method="post" action="arreglos.php" style="display:inline">
                                    <input type="hidden" name="accion" value="remover_prod" />
                                    <input type="hidden" name="idx" value="<?= (int)$i ?>" />
                                    <button type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
            <div class="arreglo-leyenda" style="margin-top:8px;">
                <strong>Leyenda de colores</strong>
                <span class="caro-strong" style="padding:4px 8px;margin-left:10px">Alto &gt; 100</span>
                <span class="medio-strong" style="padding:4px 8px;margin-left:8px">Medio 50–100</span>
                <span class="barato-strong" style="padding:4px 8px;margin-left:8px">Bajo &lt; 50</span>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
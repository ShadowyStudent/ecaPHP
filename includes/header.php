<?php

/* 
includes/header.php
Cabecera común incluida en cada página:
- Meta tags y enlaces a hojas de estilo (Bootstrap y css/styles.css).
- Arranque/control de sesión y contador de visitas en sesión.
- Garantiza que todas las páginas hereden el mismo head y recursos.
*/

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['visitas'])) {
    $_SESSION['visitas'] = 0;
}
$_SESSION['visitas']++;

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ecaPHP - Estructuras PHP</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<header class="site-header py-3 bg-light border-bottom">
  <div class="container d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
    <div>
      <h1 class="h3 mb-1">ecaPHP</h1>
      <p class="mb-0 text-muted">Estructuras de Control y Arreglos en PHP</p>
    </div>
    <div class="text-end mt-2 mt-md-0">
      <small class="d-block text-muted">Visitas en esta sesión:
        <strong><?= htmlspecialchars($_SESSION['visitas'] ?? 0, ENT_QUOTES, 'UTF-8') ?></strong>
      </small>
    </div>
  </div>
</header>
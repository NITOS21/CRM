<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'CRM Pro') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/app.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">CRM PRO</a>
        <div class="navbar-nav">
            <a class="nav-link" href="index.php">Dashboard</a>
            <a class="nav-link" href="contacts.php">Contactos</a>
            <a class="nav-link" href="opportunities.php">Oportunidades</a>
        </div>
    </div>
</nav>
<main class="container py-4">

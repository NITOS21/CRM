<?php

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';

$title = 'Dashboard CRM';
$dbError = null;
$contacts = 0;
$openOpportunities = 0;
$pipeline = 0.0;
$latestOpportunities = [];

try {
    $pdo = getDatabaseConnection();
    $contacts = (int) $pdo->query('SELECT COUNT(*) FROM contacts')->fetchColumn();
    $openOpportunities = (int) $pdo->query("SELECT COUNT(*) FROM opportunities WHERE stage <> 'Ganada'")->fetchColumn();
    $pipeline = (float) $pdo->query("SELECT COALESCE(SUM(amount),0) FROM opportunities WHERE stage <> 'Perdida'")->fetchColumn();
    $latestOpportunities = $pdo->query('SELECT title, company, stage, amount FROM opportunities ORDER BY id DESC LIMIT 10')->fetchAll();
} catch (Throwable $exception) {
    $dbError = 'No se pudo conectar a MySQL. Revisa tus variables de entorno y ejecuta sql/schema.sql.';
}

include __DIR__ . '/includes/header.php';
?>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card card-kpi gradient-1 p-3">
            <div>Total Contactos</div>
            <div class="kpi-value"><?= $contacts ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-kpi gradient-2 p-3">
            <div>Oportunidades Abiertas</div>
            <div class="kpi-value"><?= $openOpportunities ?></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-kpi gradient-3 p-3">
            <div>Pipeline</div>
            <div class="kpi-value">$<?= number_format($pipeline, 2) ?></div>
        </div>
    </div>
</div>

<?php if ($dbError): ?>
<div class="alert alert-warning"><?= htmlspecialchars($dbError) ?></div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-semibold">Últimas oportunidades</div>
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Empresa</th>
                    <th>Etapa</th>
                    <th>Monto</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($latestOpportunities as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['company']) ?></td>
                    <td><span class="badge bg-primary-subtle text-primary-emphasis"><?= htmlspecialchars($row['stage']) ?></span></td>
                    <td>$<?= number_format((float)$row['amount'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

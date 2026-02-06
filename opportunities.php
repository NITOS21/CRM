<?php

declare(strict_types=1);

session_start();
require_once __DIR__ . '/config/database.php';

$pdo = getDatabaseConnection();
$title = 'Oportunidades';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO opportunities(title, company, stage, amount) VALUES(:title,:company,:stage,:amount)');
    $stmt->execute([
        'title' => trim($_POST['title'] ?? ''),
        'company' => trim($_POST['company'] ?? ''),
        'stage' => $_POST['stage'] ?? 'Prospección',
        'amount' => (float) ($_POST['amount'] ?? 0),
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Oportunidad creada'];
    header('Location: opportunities.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

include __DIR__ . '/includes/header.php';
?>

<?php if ($flash): ?>
<div data-flash-message="<?= htmlspecialchars($flash['message']) ?>" data-flash-type="<?= htmlspecialchars($flash['type']) ?>"></div>
<?php endif; ?>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Nueva oportunidad</div>
            <div class="card-body">
                <form method="post" class="vstack gap-2">
                    <input required class="form-control" name="title" placeholder="Título">
                    <input class="form-control" name="company" placeholder="Empresa">
                    <select class="form-select" name="stage">
                        <option>Prospección</option>
                        <option>Calificada</option>
                        <option>Propuesta</option>
                        <option>Ganada</option>
                        <option>Perdida</option>
                    </select>
                    <input class="form-control" type="number" step="0.01" min="0" name="amount" placeholder="Monto">
                    <button class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Pipeline</div>
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Título</th><th>Empresa</th><th>Etapa</th><th>Monto</th></tr></thead>
                    <tbody>
                    <?php
                    $stmt = $pdo->query('SELECT title, company, stage, amount FROM opportunities ORDER BY id DESC');
                    foreach ($stmt as $deal):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($deal['title']) ?></td>
                        <td><?= htmlspecialchars($deal['company']) ?></td>
                        <td><?= htmlspecialchars($deal['stage']) ?></td>
                        <td>$<?= number_format((float)$deal['amount'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

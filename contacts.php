<?php

declare(strict_types=1);

session_start();
require_once __DIR__ . '/config/database.php';

$pdo = getDatabaseConnection();
$title = 'Contactos';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $stmt = $pdo->prepare('INSERT INTO contacts(name, email, phone, company) VALUES(:name,:email,:phone,:company)');
        $stmt->execute([
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'company' => trim($_POST['company'] ?? ''),
        ]);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Contacto creado'];
    }

    if ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = :id');
        $stmt->execute(['id' => (int) ($_POST['id'] ?? 0)]);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Contacto eliminado'];
    }

    header('Location: contacts.php');
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
            <div class="card-header bg-white fw-semibold">Nuevo contacto</div>
            <div class="card-body">
                <form method="post" class="vstack gap-2">
                    <input type="hidden" name="action" value="create">
                    <input required class="form-control" name="name" placeholder="Nombre">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                    <input class="form-control" name="phone" placeholder="Teléfono">
                    <input class="form-control" name="company" placeholder="Empresa">
                    <button class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Lista de contactos</div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Nombre</th><th>Email</th><th>Empresa</th><th></th></tr></thead>
                    <tbody>
                    <?php
                    $stmt = $pdo->query('SELECT id, name, email, company FROM contacts ORDER BY id DESC');
                    foreach ($stmt as $contact):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($contact['name']) ?></td>
                        <td><?= htmlspecialchars($contact['email']) ?></td>
                        <td><?= htmlspecialchars($contact['company']) ?></td>
                        <td class="text-end">
                            <form method="post" data-confirm-delete>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= (int)$contact['id'] ?>">
                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

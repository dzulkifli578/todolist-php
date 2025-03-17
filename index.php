<?php
require 'connection.php';

$title = "To-Do List App";
$username = "Guest";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $name = $_GET['name'] ?? '';
    $date = $_GET['date'] ?? '';

    $query = "SELECT * FROM tasks WHERE name LIKE ?
    ORDER BY
        CASE
            WHEN status = 'unfinished' THEN 1
            WHEN status = 'finished' THEN 2
        END,
        CASE
            WHEN priority = 'high' THEN 1
            WHEN priority = 'mid' THEN 2
            WHEN priority = 'low' THEN 3
        END";

    match ($date) {
        'asc' => $query .= ', date ASC',
        'desc' => $query .= ', date DESC',
        default => ''
    };

    $prepare = $connection->prepare($query);
    $searchName = "%{$name}%";
    $prepare->bind_param('s', $searchName);

    $tasks = $prepare->execute() ? $prepare->get_result()->fetch_all(MYSQLI_ASSOC) : [];
    $prepare->close();
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List App</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="text-center mb-4"><?= htmlspecialchars($title) ?></h1>

        <div class="card p-3">
            <div class="card-body">
                <div class="d-flex flex-row mb-4">
                    <h3 class="text-start">Welcome, <?= htmlspecialchars($username) ?></h3>
                </div>

                <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-2 mb-4">
                    <div class="flex-grow-1">
                        <?php require 'create.php' ?>
                    </div>
                    <div class="flex-grow-1">
                        <?php require 'import.php' ?>
                    </div>
                    <div class="flex-grow-1">
                        <?php require 'export.php' ?>
                    </div>
                </div>

                <form class="d-flex flex-column flex-lg-row align-items-lg-center gap-2 mb-4" method="get">
                    <div class="flex-grow-1">
                        <div class="form-floating">
                            <input type="text" name="name" class="form-control" placeholder=""
                                value="<?= htmlspecialchars($_GET['name'] ?? '') ?>">
                            <label>Name</label>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="form-floating">
                            <select name="date" class="form-select" id="">
                                <option selected value="">Default</option>
                                <option value="asc" <?= htmlspecialchars($_GET['date'] ?? '') === 'asc' ? 'selected' : '' ?>>Ascending</option>
                                <option value="desc" <?= htmlspecialchars($_GET['date'] ?? '') === 'desc' ? 'selected' : '' ?>>Descending</option>
                            </select>
                            <label>Date</label>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="submit" style="width: 100%;" class="btn btn-primary">Submit</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Num</th>
                                <th>Name</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tasks)): ?>
                                <tr>
                                    <td colspan="6">
                                        <p class="text-center fw-semibold my-2">No tasks available</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($tasks as $index => $value): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($index + 1) ?></td>
                                        <td><?= htmlspecialchars($value['name']) ?></td>
                                        <td>
                                            <?= htmlspecialchars($value['priority']) ?>
                                        </td>
                                        <td>
                                            <span
                                                class="badge text-bg-<?= $value['status'] === 'finished' ? 'success' : 'danger' ?>">
                                                <?= htmlspecialchars($value['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars((new DateTime(($value['date'])))->format('Y-m-d')) ?>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-row gap-2">
                                                <?php if ($value['status'] !== 'finished'): ?>
                                                    <?php require 'update.php' ?>
                                                    <?php require 'finish.php' ?>
                                                <?php endif ?>
                                                <?php require 'delete.php' ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
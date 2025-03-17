<?php

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['import'])) {
    $fileTmpPath = $_FILES['jsonFile']['tmp_name'];
    $fileName = $_FILES['jsonFile']['name'];

    if (!file_exists($fileTmpPath)) {
        echo "<script>alert('File not found!'); window.location.href='index.php'</script>";
        exit;
    }

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if ($fileExt !== 'json') {
        echo "<script>alert('The uploaded file is not JSON!'); window.location.href='index.php'</script>";
        exit;
    }

    $json = file_get_contents($fileTmpPath);
    $tasks = json_decode($json, true);

    foreach ($tasks as $task) {
        $name = $task['name'] ?? '';
        $priority = $task['priority'] ?? '';
        $status = $task['status'] ?? '';
        $date = $task['date'] ?? '';

        if (empty($name) || empty($status) || empty($priority) || empty($date)) {
            echo "<script>alert('All field must be filled!'); window.location.href='index.php'</script>";
            exit;
        }

        if (!in_array($priority, ['high', 'mid', 'low'], true)) {
            echo "<script>alert('Invalid priority field!'); window.location.href='index.php'</script>";
            exit;
        }

        if (!in_array($status, ['finished', 'unfinished'], true)) {
            echo "<script>alert('Invalid status field!'); window.location.href='index.php'</script>";
            exit;
        }

        $query = "INSERT INTO tasks (name, priority, status, date) VALUES (?, ?, ?, ?)";
        $prepare = $connection->prepare($query);
        $prepare->bind_param('ssss', $name, $priority, $status, $date);
        $prepare->execute();
    }

    echo "<script>alert('JSON data imported successfully!'); window.location.href='index.php'</script>";
    $prepare->close();
}

?>

<button type="button" class="btn btn-success" style="width: 100%" data-bs-target="#importTaskModal" data-bs-toggle="modal">
    Import
</button>

<div class="modal fade" id="importTaskModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Task</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="import.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-floating mb-4">
                        <select name="type" class="form-select">
                            <option selected value="json">JSON</option>
                        </select>
                        <label>Type</label>
                    </div>
                    <input type="file" name="jsonFile" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="import" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
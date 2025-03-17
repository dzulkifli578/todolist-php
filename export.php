<?php

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['export'])) {
    $query = "SELECT * FROM tasks";
    $prepare = $connection->prepare($query);

    $tasks = $prepare->execute() ? $prepare->get_result()->fetch_all(MYSQLI_ASSOC) : [];
    $prepare->close();

    $json = json_encode($tasks, JSON_PRETTY_PRINT);
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="tasks.json"');
    echo $json;
    exit;
}

?>

<form action="export.php" method="get">
    <button type="submit" name="export" class="btn btn-warning" style="width: 100%">Export JSON</button>
</form>
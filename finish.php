<?php

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finish'])) {
    $id = $connection->real_escape_string($_POST['id'] ?? '');
    $status = 'finished';

    if (empty($id)) {
        echo "<script>alert('ID must be filled!'); window.location.href='index.php'</script>";
        exit;
    }

    $query = "UPDATE tasks SET status = ? WHERE id = ?";
    $prepare = $connection->prepare($query);
    $prepare->bind_param('si', $status, $id);

    if ($prepare->execute())
        echo "<script>alert('Task finished successfully!'); window.location.href='index.php'</script>";
    else
        echo "<script>alert('Error finishing task!'); window.location.href='index.php'</script>";

    $prepare->close();
}

?>

<form action="finish.php" method="post"
    onsubmit="return confirm('Are you sure you want to finish <?= htmlspecialchars($value['name']) ?> task?')">
    <input type="hidden" name="id"
        value="<?= htmlspecialchars($value['id']) ?>">
    <button type="submit" name="finish" class="btn btn-success">
        Finish
    </button>
</form>
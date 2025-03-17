<?php

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $connection->real_escape_string($_POST['id'] ?? '');

    if (empty($id)) {
        echo "<script>alert('ID must be filled!'); window.location.href='index.php'</script>";
        exit;
    }

    $query = "DELETE FROM tasks WHERE id = ?";
    $prepare = $connection->prepare($query);
    $prepare->bind_param('i', $id);

    if ($prepare->execute())
        echo "<script>alert('Task deleted successfully!'); window.location.href='index.php'</script>";
    else
        echo "<script>alert('Error deleting task!'); window.location.href='index.php'</script>";

    $prepare->close();
}

?>

<form action="delete.php" method="post"
    onsubmit="return confirm('Are you sure you want to delete <?= htmlspecialchars($value['name']) ?> task?')">
    <input type="hidden" name="id"
        value="<?= htmlspecialchars($value['id']) ?>">
    <button type="submit" name="delete" class="btn btn-danger">
        Delete
    </button>
</form>
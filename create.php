<?php

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $name = $connection->real_escape_string($_POST['name'] ?? '');
    $priority = $connection->real_escape_string($_POST['priority'] ?? '');
    $status = 'unfinished';
    $date = (new DateTime())->format('Y-m-d H:i:s');

    if (empty($name) || empty($priority)) {
        echo "<script>alert('All input must be filled!'); window.location.href='index.php'</script>";
        exit;
    }

    $query = "INSERT INTO tasks (name, priority, status,   date) VALUES (?, ?, ?, ?)";
    $prepare = $connection->prepare($query);
    $prepare->bind_param('ssss', $name, $priority, $status, $date);

    if ($prepare->execute())
        echo "<script>alert('Task successfully added!'); window.location.href='index.php'</script>";
    else
        echo "<script>alert('Error creating task.'); window.location.href='index.php'</script>";

    $prepare->close();
}
?>


<button type="button" class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
    data-bs-target="#createTaskModal">
    Create Task
</button>

<div class="modal fade" id="createTaskModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Task</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-floating mb-4">
                        <input type="text" name="name" class="form-control" placeholder="" required>
                        <label>Name</label>
                    </div>
                    <div class="form-floating">
                        <select name="priority" class="form-select">
                            <option selected disabled value="">Select</option>
                            <option value="high">High</option>
                            <option value="mid">Mid</option>
                            <option value="low">Low</option>
                        </select>
                        <label>Priority</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="create" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
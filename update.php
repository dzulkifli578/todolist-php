<?php

require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $connection->real_escape_string($_POST['id'] ?? '');
    $name = $connection->real_escape_string($_POST['name'] ?? '');
    $priority = $connection->real_escape_string($_POST['priority'] ?? '');
    $status = 'unfinished';
    $date = (new DateTime())->format('Y-m-d H:i:s');

    if (empty($id) || empty($name) || empty($priority)) {
        echo "<script>alert('All input must be filled!'); window.location.href='index.php'</script>";
        exit;
    }

    $query = "UPDATE tasks SET name = ?, priority = ?, status = ?, date = ? WHERE id = ?";
    $prepare = $connection->prepare($query);
    $prepare->bind_param('ssssi', $name, $priority, $status, $date, $id);

    if ($prepare->execute())
        echo "<script>alert('Task updated successfully!'); window.location.href='index.php'</script>";
    else
        echo "<script>alert('Error updating task!'); window.location.href='index.php'</script>";

    $prepare->close();
}

?>

<button type="button" class="btn btn-warning" data-bs-toggle="modal"
    data-bs-target="#updateTaskModal"
    data-id="<?= htmlspecialchars($value['id']) ?>"
    data-name="<?= htmlspecialchars($value['name']) ?>"
    data-priority="<?= htmlspecialchars($value['priority']) ?>"
    data-status="<?= htmlspecialchars($value['status']) ?>"
    data-date="<?= htmlspecialchars($value['date']) ?>">
    Update
</button>

<div class="modal fade" id="updateTaskModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Task</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="update.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="taskId" name="id">
                    <div class="form-floating mb-4">
                        <input type="text" id="taskName" name="name" class="form-control"
                            placeholder="" required>
                        <label>Name</label>
                    </div>
                    <div class="form-floating">
                        <select id="taskPriority" name="priority" class="form-select">
                            <option selected disabled value="">Select</option>
                            <option value="high">High</option>
                            <option value="mid">Mid</option>
                            <option value="low">Low</option>
                        </select>
                        <label>Priority</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="update" class="btn btn-primary"">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const updateTaskModal = document.getElementById('updateTaskModal');

    updateTaskModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const taskId = button.getAttribute('data-id');
        const taskName = button.getAttribute('data-name');
        const taskPriority = button.getAttribute('data-priority');
        const taskStatus = button.getAttribute('data-status');
        const taskDate = button.getAttribute('data-date');

        const inputId = document.getElementById('taskId');
        inputId.value = taskId;
        const inputName = document.getElementById('taskName');
        inputName.value = taskName;
        const selectPriority = document.getElementById("taskPriority");
        selectPriority.value=taskPriority;
    });
</script>
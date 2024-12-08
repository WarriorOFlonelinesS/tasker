<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['tasks'])) {
        file_put_contents('tasks.txt', json_encode($data, JSON_PRETTY_PRINT));
        echo json_encode(['status' => 'success', 'tasks' => $data['tasks']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
    }

} else { 

    if (file_exists('tasks.txt')) {
        $tasks = file_get_contents('tasks.txt');
        $tasksData = json_decode($tasks, true);

        if (isset($tasksData['tasks'])) {
            echo json_encode(['status' => 'success', 'tasks' => $tasksData['tasks']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tasks not found in the file.']);
        }
    } else {
        echo json_encode(['status' => 'success', 'tasks' => []]);
    }
}
?>

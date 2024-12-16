<?php
require 'connect.php';
$pdo = connect('', 'tasks', '', '');

// header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['tasks']) && is_array($data['tasks'])) {
        try {
            $addedTasks = [];
            foreach ($data['tasks'] as $task) {
    
                if (!isset($task['name'])) {
                    throw new Exception("Invalid task structure: Missing 'name'");
                }

                $name = $task['name'];

                $status = isset($task['status']) && $task['status'] !== '' ? filter_var($task['status'], FILTER_VALIDATE_BOOLEAN) : false;

                echo $status;
                // Insert into database
                $query = $pdo->prepare("INSERT INTO user_tasks (name, status, date_creation) VALUES (?, ?, NOW())");
                $query->execute([$name, $status]);

                $addedTasks[] = $pdo->lastInsertId();
            }
            echo json_encode(['status' => 'success', 'addedTasks' => $addedTasks]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
    }
}

else { 

    try {
    
    // Query to fetch all tables in the public schema
        $query = "SELECT * FROM  user_tasks";
    
        // Execute the query
        $stmt = $pdo->query($query);
    
        // Fetch and display the table names
        echo "Tables in the database:<br>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo var_dump($row);
            echo $row['id'] . ',' . $row['name'] . ',' . (string)$row["status"] . '<br>';
        }
    } catch (PDOException $e) {
        // Handle connection or query error
        echo "Error: " . $e->getMessage();
    }
}

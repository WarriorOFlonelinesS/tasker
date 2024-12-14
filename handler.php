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
                $status = 'false';


                // Insert into database
                $query = $pdo->prepare("INSERT INTO public.tasks (name, status, date_creation) VALUES (?, ?, NOW())");
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
        $query = "SELECT * FROM  public.tasks";
    
        // Execute the query
        $stmt = $pdo->query($query);
    
        // Fetch and display the table names
        echo "Tables in the database:<br>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo var_dump($row);
        }
    } catch (PDOException $e) {
        // Handle connection or query error
        echo "Error: " . $e->getMessage();
    }
}

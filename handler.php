<?php
require 'connect.php';
$pdo = connect('127.127.126.49', 'tasks', 'postgres', '');

header('Content-Type: application/json');

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {


//     if (isset($data['tasks']) && is_array($data['tasks'])) {

//         try {
//             $addedTasks = [];
//             foreach ($data['tasks'] as $task) {
              
//                 if (!isset($task['name'])) {
//                     throw new Exception("Invalid task structure: Missing 'name'");
//                 }

//                 $name = $task['name'];
//                 $status = isset( $task['status']) && $task['status'] == false ? "false" : "true";
//                 // Insert into database
//                 $query = $pdo->prepare("INSERT INTO user_tasks (name, status, created_at) VALUES (?, ?, NOW())");
//                 $query->execute([$name, $status]);

//                 $addedTasks = $pdo->lastInsertId();
//             }
//             echo json_encode(['status' => 'success', 'addedTasks' => $addedTasks]);
//         } catch (PDOException $e) {
//             error_log($e->getMessage());
//             echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
//         } catch (Exception $e) {
//             error_log($e->getMessage());
//             echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
//         }
//     } else {
//         echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
//     }
// } else {

//     try {
//         $data = [];
//         // Query to fetch all tables in the public schema
//         $query = "SELECT * FROM  user_tasks";

//         // Execute the query
//         $stmt = $pdo->query($query);

//         // Fetch and display the table names
//         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//             // echo var_dump($row);
//             // echo $row['id'] . ',' . $row['name'] . ',' . (string) $row["status"] . '<br>';
//             array_push($data, $row);
//         }
        
//         echo json_encode(['status' => 'success', 'addedTasks' => $data]);

//     } catch (PDOException $e) {
//         // Handle connection or query error
//         echo "Error: " . $e->getMessage();
//     }
// }


switch ($_SERVER['REQUEST_METHOD']) {
    case "POST":
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);
        try {
            $addedTasks = [];
            foreach ($data['tasks'] as $task) {
                if (!isset($task['name'])) {
                    throw new Exception("Invalid task structure: Missing 'name'");
                }

                $name = $task['name'];
                $status = isset($task['status']) && $task['status'] == false ? "false" : "true";

                // Insert into database
                $query = $pdo->prepare("INSERT INTO user_tasks (name, status, created_at) VALUES (?, ?, NOW())");
                $query->execute([$name, $status]);

                $addedTasks[] = $pdo->lastInsertId(); // Append to array
            }
            echo json_encode(['status' => 'success', 'addedTasks' => $addedTasks]);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        } catch (Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    case "GET":
        try {
            $data = [];
            // Query to fetch all tasks from the database
            $query = "SELECT * FROM user_tasks";
            $stmt = $pdo->query($query);

            // Fetch all rows and add to the data array
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($data, $row);
            }

            // Output only pure JSON
            echo json_encode(['status' => 'success', 'tasks' => $data]);
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Incorrect method']);
        break;
}

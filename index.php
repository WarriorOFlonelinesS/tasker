<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tasker</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<main>
  <h1>TODO</h1>
  <form id="add-task-form" method="post">
    <input type="text" placeholder="Tarefa" name="task" id="add-task-input" />
    <button type="submit">Add</button>
  </form>
  <ul id="task-list"></ul>
  <script src="./script.js"></script>
</main>
</body>
</html>
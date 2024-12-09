Tasker
Tasker is a simple to-do list web application that allows users to manage their tasks. It provides the ability to add, update, toggle, and remove tasks, with tasks stored in a JSON file on the server.

Features
Add new tasks with a name.
Update task names.
Toggle task completion status.
Delete tasks.
Persistent task storage using a tasks.txt file on the server.
Project Structure
 
  
project/
├── index.html      # Main HTML file
├── style.css       # (Optional) Styles for the app
├── script.js       # Client-side JavaScript
├── handler.php     # Server-side task handler
└── tasks.txt       # Persistent task storage (auto-generated)
How It Works
Frontend
HTML
The app provides a simple interface where users can:

Add a task via a form.
View tasks as a list.
Interact with each task (update, toggle status, delete).
JavaScript
The frontend uses JavaScript to:

Fetch tasks from the server using fetch.
Dynamically update the DOM when tasks are modified.
Send updates (add, update, toggle, delete) to the server.
Backend
PHP Handler (handler.php)

GET Requests: Returns the list of tasks stored in tasks.txt.
POST Requests: Updates the tasks.txt file with new tasks from the client.
File Storage (tasks.txt)

Stores tasks in JSON format for persistent storage.
Installation and Setup
Clone the repository or download the files.
Ensure you have a PHP server set up (e.g., XAMPP).
Place the project in your web server's root directory (e.g., htdocs for XAMPP).
Start your PHP server.
Open index.html in your browser.
Usage
Add a Task
Enter a task name in the input field.
Click the "Add" button or press Enter.
Update a Task Name
Click on the task name.
Enter a new name in the prompt.
Toggle Task Status
Click the checkbox next to a task.
Delete a Task
Click the "Delete" button next to a task.
Code Overview
JavaScript (script.js)
Key Functions:
apiRequest(url, method, body): Sends API requests to the server.
getTasks(): Fetches tasks from the server.
saveTasks(): Saves tasks to the server.
addTask(task): Adds a new task.
updateTaskName(id, name): Updates the name of a task.
toggleTaskStatus(id): Toggles the completion status of a task.
removeTask(id): Removes a task.
renderTasks(): Updates the DOM with the current tasks.
Initialization:
On page load, tasks are fetched from the server and displayed.
PHP (handler.php)
Key Logic:
POST Requests:
Accepts JSON payload with a tasks array.
Validates the input and saves it to tasks.txt.
Returns a success or error message.
GET Requests:
Reads tasks from tasks.txt.
Returns the tasks as JSON or an empty array if the file doesn’t exist.
Example Task Workflow
Add Task:
Input:

json
  
{ "id": "abc123", "name": "Buy milk", "status": false }
Server Response:

json
  
{ "status": "success", "tasks": [...] }
Update Task Name:

Find the task by id.
Update the name.
Toggle Task Status:

Find the task by id.
Flip the status value.
Delete Task:

Remove the task by id from the list.
Notes
Ensure the PHP server has write permissions for the directory where tasks.txt is located.
This app is designed for demonstration purposes and may require enhancements for production use.
Future Improvements
Add authentication to prevent unauthorized access.
Validate input to avoid invalid task data.
Implement a database for more scalable storage.
Improve the UI/UX with additional styling and animations.
Enjoy managing your tasks with Tasker! 🎯
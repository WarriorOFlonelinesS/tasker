<h1>Tasker</h1>
<p>Tasker is a simple to-do list web application that allows users to manage their tasks. It supports adding, updating, toggling, and removing tasks, with persistent storage using a server-side JSON file.</p>

<h2>Features</h2>
<ul>
    <li>Add new tasks with a name.</li>
    <li>Update task names.</li>
    <li>Toggle task completion status.</li>
    <li>Delete tasks.</li>
    <li>Persistent storage using a <code>tasks.txt</code> file.</li>
</ul>

<h2>Project Structure</h2>
<pre>
project/
├── index.html      # Main HTML file
├── style.css       # (Optional) Styles for the app
├── script.js       # Client-side JavaScript
├── handler.php     # Server-side task handler
└── tasks.txt       # Persistent task storage (auto-generated)
</pre>

<h3>Key Functionality</h3>
<p>The app provides a user interface for:</p>
<ul>
    <li>Adding tasks via a form.</li>
    <li>Viewing tasks as a list.</li>
    <li>Interacting with tasks (update, toggle, delete).</li>
</ul>

<h2>Code Overview</h2>
<h3>JavaScript</h3>
<p>The frontend uses JavaScript to fetch tasks, dynamically update the DOM, and send updates to the server:</p>
<ul>
    <li><strong>apiRequest(url, method, body):</strong> Sends requests to the server.</li>
    <li><strong>getTasks():</strong> Fetches tasks from the server.</li>
    <li><strong>saveTasks():</strong> Saves tasks to the server.</li>
    <li><strong>addTask(task):</strong> Adds a new task.</li>
    <li><strong>updateTaskName(id, name):</strong> Updates a task name.</li>
    <li><strong>toggleTaskStatus(id):</strong> Toggles a task's completion status.</li>
    <li><strong>removeTask(id):</strong> Deletes a task.</li>
    <li><strong>renderTasks():</strong> Updates the task list in the DOM.</li>
</ul>

<h3>PHP (handler.php)</h3>
<p>Handles server-side logic:</p>
<ul>
    <li><strong>GET Requests:</strong> Returns tasks stored in <code>tasks.txt</code>.</li>
    <li><strong>POST Requests:</strong> Updates tasks in <code>tasks.txt</code> based on client input.</li>
</ul>

<h3>File Storage</h3>
<p>Tasks are stored persistently in <code>tasks.txt</code> in JSON format.</p>

<h2>Installation</h2>
<ol>
    <li>Clone the repository or download the files.</li>
    <li>Set up a PHP server (e.g., XAMPP).</li>
    <li>Place the project in the server's root directory (e.g., <code>htdocs</code> for XAMPP).</li>
    <li>Start the server and open <code>index.html</code> in a browser.</li>
</ol>

<h2>Usage</h2>
<ul>
    <li><strong>Add a Task:</strong> Enter a task name and click "Add" or press Enter.</li>
    <li><strong>Update Task Name:</strong> Click on a task name and provide a new name.</li>
    <li><strong>Toggle Task Status:</strong> Click the checkbox next to a task.</li>
    <li><strong>Delete a Task:</strong> Click "Delete" next to a task.</li>
</ul>

<h2>Notes</h2>
<p>Ensure the server has write permissions for the directory containing <code>tasks.txt</code>. This app is for demonstration purposes and may require enhancements for production use.</p>

<h2>Future Improvements</h2>
<ul>
    <li>Authentication for security.</li>
    <li>Input validation to prevent invalid task data.</li>
    <li>Database integration for scalability.</li>
    <li>Enhanced UI/UX with better styling and animations.</li>
</ul>

<p>Enjoy managing your tasks with Tasker! 🎯</p>

const handler = './handler.php';
let tasksCache = [];

async function apiRequest(url, method = 'GET', body = null) {
  try {
    const response = await fetch(url, {
      method,
      headers: {
        'Content-Type': 'application/json',
      },
      body: body ? JSON.stringify(body) : null,
    });

    if (!response.ok) {
      const errorText = await response.text(); // Read the body as text for error logging
      throw new Error(`HTTP error! status: ${response.status}, body: ${errorText}`);
    }

    const responseData = await response.json(); // Parse the JSON once
    return responseData;
  } catch (error) {
    console.error('API request error:', error);
    return null;
  }
}


async function getTasks() {
  const response = await apiRequest(handler);
  tasksCache = response?.tasks || [];
  return tasksCache;
}

async function saveTasks() {
  const response = await apiRequest(handler, 'POST', { tasks: tasksCache });
  if (response?.status !== 'success') {
    console.error('Failed to save tasks:', response?.message || 'Unknown error');
  }
}

function addTask(task) {
  tasksCache.push(task);
  saveTasks();
  renderTasks();
}
function updateTaskName(id, name) {
  const task = tasksCache.find((task) => task.id === id);
  if (task) {
    task.name = name;
    saveTasks();
    renderTasks();
  }
}

function toggleTaskStatus(id) {
  const task = tasksCache.find((task) => task.id === id);
  if (task) {
    task.status = !task.status;
    saveTasks();
    renderTasks();
  }
}

async function removeTask(id) {
  const response = await apiRequest(handler, "DELETE", {id});
  if (response?.status === 'error') {
    console.error('Failed to save tasks:', response?.message || 'Unknown error');
  }
  console.log(response.message)

  tasksCache = tasksCache.filter((task) => task.id !== id);
  renderTasks();
}

function createTaskElement(task) {
  const listItem = document.createElement('li');
  listItem.className = 'task-item';

  const checkbox = document.createElement('input');
  checkbox.type = 'checkbox';
  checkbox.setAttribute('name', 'status');
  checkbox.checked = task.status;
  checkbox.value = false
  checkbox.addEventListener('change', () => {
    toggleTaskStatus(task.id);
  });

  const name = document.createElement('span');
  name.setAttribute('name', 'name');
  name.innerText = task.name;
  name.addEventListener('click', () => {
    const newName = prompt('Update task name:', task.name);
    if (newName) {
      updateTaskName(task.id, newName);
    }
  });

  const removeButton = document.createElement('button');
  removeButton.innerText = 'Delete';
  removeButton.addEventListener('click', () => {
    removeTask(task.id);
  });

  listItem.appendChild(checkbox);
  listItem.appendChild(name);
  listItem.appendChild(removeButton);

  return listItem;
}

function renderTasks() {
  const taskList = document.getElementById('task-list');
  taskList.innerHTML = '';

  for (const task of tasksCache) {
    const taskElement = createTaskElement(task);
    taskList.appendChild(taskElement);
  }
}

function onAddTask(event) {
  event.preventDefault();
  const taskInput = document.getElementById('add-task-input');
  if (taskInput.value.trim()) {
    addTask({
      id: crypto.randomUUID(),
      name: taskInput.value.trim(),
      status: false,
    });
    taskInput.value = '';
  }
}

async function init() {
  await getTasks();
  renderTasks();

  const taskForm = document.getElementById('add-task-form');
  taskForm.addEventListener('submit', onAddTask);
}

window.addEventListener('load', init);

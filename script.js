async function save (tasks) {
  const handler = './handler.php'
  fetch(handler, {
  method: 'POST', // Specify the HTTP method
  headers: {
    'Content-Type': 'application/json' // Set the content type to JSON
  },
  body: JSON.stringify(data) // Convert JavaScript object to JSON string
})
  .then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json(); // Parse the JSON response
  })
  .then(data => {
    console.log('Success:', data); // Handle the JSON response
  })
  .catch(error => {
    console.error('Error:', error); // Handle errors
  });
}

async function getTasks() {
  const tasks = await fetch(handler).then(response =>response => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json(); // Parse the JSON response
  })
  .then(data => data)
  if (!tasks) return [];
  return tasks;
}

function addTask(task) {
  const tasks = getTasks();
  tasks.push(task);
  save(tasks);
}

function updataTaskName(id, name) {
  const tasks = getTasks();
  for (const task of tasks) {
    if (task.id === id) {
      task.name = name;
      save(tasks);
      break;
    }
  }
}

function updataTaskStatus(id) {
  const tasks = getTasks();
  for (const task of tasks) {
    if (task.id === id) {
      task.status = !task.status;
      break;
    }
  }
  save(tasks);
}

function removeTask(id) {
  const tasks = getTasks();
  const newTasks = tasks.filter((task) => task.id !== id);
  save(newTasks);
}

function createRemoveButtonElement(id, status) {
  const REMOVE_BUTTON = document.createElement("button");

  REMOVE_BUTTON.innerText = "Delete";
  REMOVE_BUTTON.classList.add("remove-button");
  REMOVE_BUTTON.disabled = status;

  REMOVE_BUTTON.addEventListener("click", function () {
    removeTask(id);
    renderTasks();
  });

  return REMOVE_BUTTON;
}

function createCheckboxTaskElement(id, status) {
  const TASK_ITEM_CHECKBOX = document.createElement("input");

  TASK_ITEM_CHECKBOX.type = "checkbox";
  TASK_ITEM_CHECKBOX.checked = status;
  TASK_ITEM_CHECKBOX.classList.add("task-item-checkbox");

  TASK_ITEM_CHECKBOX.addEventListener("change", function (event) {
    console.log("change", id);
    updataTaskStatus(id);
    renderTasks();
  });

  return TASK_ITEM_CHECKBOX;
}

function createNameTaskElement(task) {
  const TASK_ITEM_NAME = document.createElement("span");

  TASK_ITEM_NAME.innerText = task.name;
  TASK_ITEM_NAME.classList.add("task-item-name");
  TASK_ITEM_NAME.addEventListener("click", function () {
    updataTaskStatus(task.id);
    renderTasks();
  });

  return TASK_ITEM_NAME;
}

function createTaskElement(task) {
  const TASK_ITEM = document.createElement("li");
  const TASK_ITEM_CHECKBOX = createCheckboxTaskElement(task.id, task.status);
  const REMOVE_BUTTON = createRemoveButtonElement(task.id, task.status);
  const TASK_ITEM_NAME = createNameTaskElement(task);

  TASK_ITEM.classList.add("task-item");
  TASK_ITEM.appendChild(TASK_ITEM_CHECKBOX);
  TASK_ITEM.appendChild(TASK_ITEM_NAME);
  TASK_ITEM.appendChild(REMOVE_BUTTON);

  return TASK_ITEM;
}

function renderTasks() {
  const TASK_LIST = document.getElementById("task-list");
  TASK_LIST.innerHTML = "";
  const tasks = getTasks();

  if (tasks) {
    for (const task of tasks) {
      const TASK_ITEM = createTaskElement(task);
      TASK_LIST.appendChild(TASK_ITEM);
    }
  }
}

function onAddTaskForm(event) {
  event.preventDefault();
  const ADD_TASK_INPUT = document.getElementById("add-task-input");
  addTask({
    id: crypto.randomUUID(),
    name: ADD_TASK_INPUT.value,
    status: false
  });
  ADD_TASK_INPUT.value = "";
  renderTasks();
}

window.addEventListener("load", renderTasks);

const ADD_TASK_FORM = document.getElementById("add-task-form");
ADD_TASK_FORM.addEventListener("submit", onAddTaskForm);

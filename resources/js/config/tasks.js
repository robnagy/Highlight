let TASKS_TEMPLATE = {
        "name": "",
        "status": "",
        "expanded": false,
        "subtasks": [],
        "tags": [],
};
let TASK_GENERATOR = (name, status, expanded, subtasks, tags, id) => {
    console.log("task generator running");
    let newTask = _.cloneDeep(TASKS_TEMPLATE);
    if (name) newTask.name = name;
    if (status) newTask.status = status;
    if (expanded) newTask.expanded = expanded;
    if (subtasks) newTask.subtasks = subtasks;
    if (tags) newTask.tags = tags;
    if (id) newTask.id = id;
    return newTask;
};
let TASK_STATUS = {
    completed: "completed",
    deleted: "deleted",
    editing: "editing",
    expanded: "expanded",
    selected: "selected",
    new: "new",
};
let TASKS_TYPE = {
    main: "main",
    subtasks: "subtasks",
};
let TASKS_EVENT_NAME = {
    taskAdded: "taskAdded",
    taskRenamed: "taskRenamed",
    taskStatusChanged: "taskStatusChanged",
    taskToggleExpanded: "taskToggleExpanded",
    taskUpdated: "taskUpdated",
    tasksUpdated: "tasksUpdated",
};
let TASKS_EVENT = {
    taskAdded(context, task) {
        context.$emit(TASKS_EVENT_NAME.taskAdded, task);
    },
    taskToggleExpanded(context) {
        context.$emit(TASKS_EVENT_NAME.taskToggleExpanded)
    },
    taskRenamed(context, name) {
        context.$emit(TASKS_EVENT_NAME.taskRenamed, name)
    },
    taskStatusChanged(context, index, status) {
        context.$emit(TASKS_EVENT_NAME.taskStatusChanged, {index, status})
    },
    taskUpdated(context, task) {
        task = _.cloneDeep(task);
        context.$emit(TASKS_EVENT_NAME.taskUpdated, task)
    },
    tasksUpdated(context, tasks) {
        // tasks = _.cloneDeep(tasks);
        context.$emit(TASKS_EVENT_NAME.tasksUpdated, tasks)
    },
};

export {TASKS_TEMPLATE, TASK_GENERATOR, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE, TASKS_UTILITY};

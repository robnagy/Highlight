let TASKS_TEMPLATE = {
        "name": "",
        "status": "",
        "expanded": false,
        "subTasks": []
};
let TASK_GENERATOR = (name, status, expanded, subTasks) => {
    let newTask = _.cloneDeep(TASKS_TEMPLATE);
    if (name) newTask.name = name;
    if (status) newTask.status = status;
    if (expanded) newTask.expanded = expanded;
    if (subTasks) newTask.subTasks = subTasks;
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
    subTasks: "subTasks",
};
let TASKS_EVENT_NAME = {
    taskRenamed: "taskRenamed",
    taskStatusChanged: "taskStatusChanged",
    taskToggleExpanded: "taskToggleExpanded",
    taskUpdated: "taskUpdated",
    tasksUpdated: "tasksUpdated",
};
let TASKS_EVENT = {
    taskToggleExpanded(context) {
        // console.log('tasks.js event toggleExpanded triggered');
        context.$emit(TASKS_EVENT_NAME.taskToggleExpanded)
    },
    taskRenamed(context, name) {
        context.$emit(TASKS_EVENT_NAME.taskRenamed, name)
    },
    taskStatusChanged(context, index, status) {
        console.log('tasks.js taskStatusChange triggered: '+status+" index:"+index);
        context.$emit(TASKS_EVENT_NAME.taskStatusChanged, {index, status})
    },
    taskUpdated(context, task) {
        task = _.cloneDeep(task);
        console.log('tasks.js event function, updated task received');
        console.log(task);
        context.$emit(TASKS_EVENT_NAME.taskUpdated, task)
    },
    tasksUpdated(context, tasks) {
        // tasks = _.cloneDeep(tasks);
        console.log('tasks.js event function, updated tasks received');
        context.$emit(TASKS_EVENT_NAME.tasksUpdated, tasks)
    },
};
let TASKS_UTILITY = {
    select(index, tasks) {
        console.log("tasks utility running, tasks received are");
        console.log(tasks);
        console.log(index);
        tasks.forEach(function(task){
            if (task.status === TASK_STATUS.selected) {
                task.status = TASK_STATUS.new;
            }
        });
        if (tasks[index].status !== TASK_STATUS.completed) {
            tasks[index].status = TASK_STATUS.selected;
        }
    }
};

export {TASKS_TEMPLATE, TASK_GENERATOR, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE, TASKS_UTILITY};
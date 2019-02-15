<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <task-list
                        :tasks="tasks"
                        @tasksUpdated="updateTasks($event)"
                        @taskStatusChanged="changeTaskStatus($event)"
                        @taskNameChanged="changeTaskName($event)"
                        @taskToggleExpanded="taskToggleExpanded()"
                        title="Tasks"
                        show-header="true"
                        button-variant="primary"
                        :type="taskListTypeMain"
                ></task-list>
            </div>
            <div class="col-md-6" v-if="taskExpanded()">
                <single-task
                        v-bind="selectedTask"
                        @taskUpdated="updateTask($event)">
                </single-task>
            </div>
        </div>
    </div>
</template>

<script>
    import {TASKS_TEMPLATE, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE, TASKS_UTILITY} from '../config/tasks';
    import TaskList from '../components/TaskListComponent.vue';
    import SingleTask from '../components/SingleTaskComponent';
    export default {
        data() {
            return {
                "title":"Tasks",
                "tasks": [],
                "selectedTaskIndex": null,
                "selectedTaskExpanded": false
            }
        },
        components: {
            SingleTask,
            TaskList
        },
        mounted() {},
        methods: {
            getTasks: function (type, index) {
                switch (type) {
                    case 'main':
                        return this.tasks;
                    case '':
                        break;
                }
            },
            changeTaskStatus: function (data) {
                let index = data.index;
                switch (data.status) {
                    case TASK_STATUS.new:
                        this.tasks[index].status = TASK_STATUS.new;
                        break;
                    case TASK_STATUS.editing:
                        this.tasks[index].status = TASK_STATUS.editing;
                        break;
                    case TASK_STATUS.selected:
                        this.selectTask(index);
                        break;
                    case TASK_STATUS.completed:
                        this.tasks[index].status = TASK_STATUS.completed;
                        break;
                    case TASK_STATUS.deleted:
                        this.tasks.splice(index, 1);
                        break;
                }
            },
            changeTaskName: function (data) {
                let index = data.index;
                this.tasks[index].name = data.name;
            },
            changeSubTaskName: function (data) {
                let index = data.index;
                this.tasks[this.selectedTaskIndex].subTasks[index].name = data.name;
            },
            selectTask: function(index) {
                this.selectedTaskIndex = null;
                TASKS_UTILITY.select(index, this.tasks);
                this.selectedTaskIndex = index;
            },
            taskExpanded: function() {
                if (this.tasks !== null) {
                    if (this.tasks.length > 0) {
                        if (this.selectedTaskIndex != null) {
                            if (this.selectedTaskIndex > -1) {
                                if (this.tasks[this.selectedTaskIndex].expanded === true) {
                                    return true;
                                }
                            }
                        }
                    }
                }
                return false;
            },
            taskToggleExpanded: function() {
                this.tasks[this.selectedTaskIndex].expanded = !this.tasks[this.selectedTaskIndex].expanded;
            },
            updateTask: function(data) {
                this.selectedTask = data;
            },
            updateTasks: function(data) {
                this.tasks = data;
            },
        },
        computed: {
            selectedTask: {
                get: function () {
                    return this.tasks[this.selectedTaskIndex];
                },
                set: function(task) {
                    this.$set(this.tasks, this.selectedTaskIndex, task);
                }
            },
            subTaskName: function() {
                if (this.selectedTaskIndex !== null) {
                    return this.tasks[this.selectedTaskIndex].name;
                }
                return "Select a main task";
            },
            subTasks: function() {
                if (this.selectedTaskIndex !== null) {
                    return this.tasks[this.selectedTaskIndex].subTasks;
                }
                return [];
            },
            taskListTypeMain: function() {
                return TASKS_TYPE.main;
            }
        },
    }
</script>

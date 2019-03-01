<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <task-list
                        :tasks="tasks"
                        @taskAdded="addTask($event)"
                        @taskDeleted="deletedTask($event)"
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
    import {TASKS_TEMPLATE, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE} from '../config/tasks';
    import TaskList from '../components/TaskListComponent.vue';
    import SingleTask from '../components/SingleTaskComponent';
    import deleteTask from '../mixins/deleteTaskMixin';
    import loadTasksMixin from '../mixins/loadTasksMixin';
    import saveTaskMixin from '../mixins/saveTaskMixin';
    import selectTaskMixin from '../mixins/selectTaskMixin';
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
        mixins: [ deleteTask, loadTasksMixin, saveTaskMixin, selectTaskMixin ],
        mounted() {},
        methods: {
            addTask($event) {
                this.tasks.push($event);
                this.postTask($event, this.tasks.length-1);
            },
            changeTaskStatus: function (data) {
                let index = data.index;
                let change = true;
                switch (data.status) {
                    case TASK_STATUS.new:
                        this.$set(this.tasks[index], status, TASK_STATUS.new);
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
                    default:
                        change = false;
                }
                if (change) {
                    this.postTask(this.tasks[index], index);
                }
            },
            deletedTask($event, index) {
                this.deleteTask($event.id, $event.index);
                if (this.selectedTaskIndex == $event.index) {
                    this.selectedTaskIndex = null;
                }
            },
            changeTaskName(data) {
                let index = data.index;
                this.tasks[index].name = data.name;
                this.postTask(this.tasks[index], index);
            },
            changeSubtaskName(data) {
                let index = data.index;
                this.tasks[this.selectedTaskIndex].subtasks[index].name = data.name;
            },
            selectTask(index) {
                this.selectedTaskIndex = null;
                this.selectATask(index, this.tasks, this.postTask);
                this.selectedTaskIndex = index;
            },
            taskExpanded() {
                if (this.tasks !== null) {
                    if (this.tasks.length > 0) {
                        if (this.selectedTaskIndex != null) {
                            if (this.selectedTaskIndex > -1) {
                                if (this.tasks[this.selectedTaskIndex].expanded || false) {
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
                this.postTaskTrigger();
            },
            updateTask: function(data) {
                this.selectedTask = data;
            },
            updateTasks: function(data) {
                this.tasks = data;
            },
            updateSelectedTaskIndex() {
                this.tasks.some((t, index) => {
                    if (t.status === TASK_STATUS.selected) {
                        this.selectedTaskIndex = index;
                        return true;
                    } });
            }
        },
        computed: {
            selectedTask: {
                get: function () {
                    return this.tasks[this.selectedTaskIndex];
                },
                set: function(task) {
                    this.$set(this.tasks, this.selectedTaskIndex, task);
                    this.postTaskTrigger();
                }
            },
            subtaskName: function() {
                if (this.selectedTaskIndex !== null) {
                    return this.tasks[this.selectedTaskIndex].name;
                }
                return "Select a main task";
            },
            subtasks: function() {
                if (this.selectedTaskIndex !== null) {
                    return this.tasks[this.selectedTaskIndex].subtasks;
                }
                return [];
            },
            taskListTypeMain: function() {
                return TASKS_TYPE.main;
            }
        },
    }
</script>

<template>
    <div class="row justify-content-center">
        <transition name="fader">
            <div :class="tasksClass" v-if="showTasks">
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
                    :date="date"
                ></task-list>
            </div>
        </transition>
        <transition name="slide-fade">
            <div :class="subtasksClass" v-if="taskExpanded">
                <single-task
                        v-bind="selectedTask"
                        @taskDisplayDateUpdated="changeTaskDisplayDate($event)">
                </single-task>
            </div>
        </transition>
    </div>
</template>
<script>
import {TASKS_TEMPLATE, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE} from '../config/tasks';
import TaskList from './TaskListComponent.vue';
import SingleTask from './SingleTaskComponent';
import deleteTask from '../mixins/deleteTaskMixin';
import loadTasksMixin from '../mixins/loadTasksMixin';
import saveTaskMixin from '../mixins/saveTaskMixin';
import selectTaskMixin from '../mixins/selectTaskMixin';
export default {
    props: ['layout', 'tasksVisible', 'taskList'],
    data() {
        return {
            "selectedTaskExpanded": false,
            "selectedTaskIndex": null,
            "showTasks" : null,
            "tasks": [],
        }
    },
    components: {
        SingleTask,
        TaskList,
    },
    mixins: [ deleteTask, loadTasksMixin, saveTaskMixin, selectTaskMixin ],
    created() {
        this.showTasks = this.tasksVisible;
        this.tasks = _.cloneDeep(this.taskList);
        this.updateSelectedTaskIndex();
    },
    methods: {
        addTask($event) {
            this.tasks.push($event);
            this.postTask($event, this.tasks.length-1);
        },
        changeTaskStatus(data) {
            let index = data.index;
            let change = true;
            switch (data.status) {
                case TASK_STATUS.new:
                    this.$set(this.tasks[index], "status", TASK_STATUS.new);
                    break;
                case TASK_STATUS.editing:
                    this.$set(this.tasks[index], "status", TASK_STATUS.editing);
                    break;
                case TASK_STATUS.selected:
                    this.selectTask(index);
                    break;
                case TASK_STATUS.completed:
                    this.$set(this.tasks[index], "status", TASK_STATUS.completed);
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
        changeTaskDisplayDate(date) {
            const index = this.selectedTaskIndex;
            this.selectedTaskIndex = null;
            let task = this.tasks.splice(index, 1)[0];
            task.display_date = date;
            this.postTask(task, null);
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
        deletedTask($event, index) {
            this.deleteTask($event.id, $event.index);
            if (this.selectedTaskIndex == $event.index) {
                this.selectedTaskIndex = null;
            }
        },
        selectTask(index) {
            const wasSelected = this.selectedTaskIndex === index;
            let subtasksShownChange = false;
            if (this.selectedTaskIndex !== null) {
                subtasksShownChange = this.tasks[index].expanded != this.tasks[this.selectedTaskIndex].expanded;
            }

            if (!wasSelected && this.layout === "horizontal") {
                if (subtasksShownChange) this.showTasks = false;
            }
            this.selectedTaskIndex = null;
            this.selectATask(index, this.tasks, this.postTask);
            this.$nextTick(() => {
                setTimeout(() => {
                    if (!wasSelected) {
                        this.selectedTaskIndex = index;
                        if (subtasksShownChange) this.showTasks = true;
                    }
                }, 300);
            })
        },
        taskToggleExpanded() {
            const isExpanded = this.taskExpanded;
            if (this.layout === "horizontal") {
                this.showTasks = false;
            }
            if (isExpanded) {
                this.tasks[this.selectedTaskIndex].expanded = !this.tasks[this.selectedTaskIndex].expanded;
                setTimeout(() => {
                    this.showTasks = true;
                }, 300);
                this.postTaskTrigger();
            } else {
                this.showTasks = true;
                this.tasks[this.selectedTaskIndex].expanded = !this.tasks[this.selectedTaskIndex].expanded;
                this.postTaskTrigger();
            }
        },
        updateSelectedTaskIndex() {
            this.tasks.some((t, index) => {
                if (t.status === TASK_STATUS.selected) {
                    this.selectedTaskIndex = index;
                    return true;
                }
            });
        }
    },
    computed: {
        selectedTask: {
            get() {
                return this.tasks[this.selectedTaskIndex];
            },
            set(task) {
                this.$set(this.tasks, this.selectedTaskIndex, task);
                this.postTaskTrigger();
            }
        },
        subtaskName() {
            if (this.selectedTaskIndex !== null) {
                return this.tasks[this.selectedTaskIndex].name;
            }
            return "Select a main task";
        },
        subtasks() {
            if (this.selectedTaskIndex !== null) {
                return this.tasks[this.selectedTaskIndex].subtasks;
            }
            return [];
        },
        subtasksClass() {
            let classes = "subtasks ";
            if (this.layout === "vertical") {
                classes += "col-md-9 ";
            } else {
                classes += "col-md-6 ";
            }
            return classes;
        },
        taskExpanded() {
            if (this.tasks !== null) {
                if (this.tasks.length > 0) {
                    if (this.showTasks === true) {
                        if (this.selectedTaskIndex !== null) {
                            if (this.selectedTaskIndex > -1) {
                                if (this.tasks[this.selectedTaskIndex].expanded || false) {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
            return false;
        },
        tasksClass() {
            let classes = "tasks ";
            if (this.layout === "vertical") {
                classes += "col-md-9 ";
            } else {
                classes += "col-md-6 ";
            }
            return classes;
        },
        taskListTypeMain() {
            return TASKS_TYPE.main;
        }
    },
    watch: {
        taskList(newVal, oldVal) {
            this.tasks = _.cloneDeep(newVal);
            this.updateSelectedTaskIndex();
        },
        tasksVisible(newVal) {
            this.showTasks = newVal;
        }
    }
}
</script>

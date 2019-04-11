<template>
    <div class="card card-default">
        <div class="card-header">
            <h3>{{ name }} <span class="fas fa-list"></span></h3>
        </div>
        <div class="card-body">
            <div>
                <task-list
                    :tasks="watchedSubtasks"
                    title="Sub-Tasks"
                    @taskDeleted="deletedSubtask($event)"
                    @taskStatusChanged="changeSubtaskStatus($event)"
                    @taskNameChanged="changeSubtaskName($event)"
                    @taskAdded="newSubtaskAdded($event)"
                    show-header="false"
                    :type="taskListTypeSub"
                    button-variant="primary"
                    button-size="sm"
                ></task-list>
            </div>

            <tags-component :taskid="id" @tagsUpdated="updateHandler($event, 'tags')"></tags-component>
            <hr>
            <div class="row">
                <div class="col-md-3 due-date-text">
                    Due date:
                </div>
                <div class="col-md-6">
                    <datepicker
                        :value="taskDate"
                        :bootstrap-styling="true"
                        @selected="changeTaskDisplayDate($event)"
                    ></datepicker>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import {TASKS_TEMPLATE, TASK_GENERATOR, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE, TASKS_UTILITY} from '../config/tasks';
    import TaskList from "./TaskListComponent.vue";
    import TagsComponent from "./TagsComponent";
    import loadSubtasksMixin from '../mixins/loadSubtasksMixin';
    import saveSubtaskMixin from '../mixins/saveSubtaskMixin';
    import deleteSubtaskMixin from '../mixins/deleteSubtaskMixin';
    import selectTaskMixin from '../mixins/selectTaskMixin';
    import datesMixin from '../mixins/datesMixin';
    export default {
        components: { Datepicker, TaskList, TagsComponent },
        mixins: [datesMixin, deleteSubtaskMixin, loadSubtasksMixin, saveSubtaskMixin, selectTaskMixin],
        props: ['name', 'status', 'expanded', 'tags', 'id', 'display_date'],
        data() {
            return {
                'subtasks': [],
                'showSubtasks': false,
                'watchedSubtasks': [],
            }
        },
        mounted() {
            this.watchedSubtasks = _.cloneDeep(this.subtasks);
        },
        methods: {
            changeTaskDisplayDate($event) {
                if ($event.toDateString() !== this.taskDate.toDateString()) {
                    TASKS_EVENT.taskDisplayDateUpdated(this, this.formatDate($event));
                }
            },
            deletedSubtask($event) {
                this.deleteSubtask($event, this.id);
            },
            newSubtaskAdded($event) {
                let index = this.subtasks.push($event) - 1;
                this.postSubtask($event, index);
            },
            getNewTask() {
                return TASK_GENERATOR(this.name, this.status, this.expanded, this.subtasks, this.tags, this.id);
            },
            changeSubtaskName($event) {
                this.$set(this.subtasks[$event.index], 'name', $event.name);
                this.postSubtask(this.subtasks[$event.index], $event.index);
            },
            changeSubtaskStatus($event) {
                let onDeselect = (task, index) => {
                    this.postSubtask(task, index);
                }
                if ($event.status == TASK_STATUS.selected) {
                    let onChange = (task, index) => { this.postSubtask(task, index); }
                    this.selectATask($event.index, this.subtasks, onChange);
                } else {
                    this.$set(this.subtasks[$event.index], 'status', $event.status);
                }
                this.postSubtask(this.subtasks[$event.index], $event.index);
            },
            updateHandler($event, type) {
                let newTask = this.getNewTask();
                newTask[type] = $event;
                this.updateParentTask(newTask);
            },
        },
        computed: {
            showSubtaskText() {
                if (this.subtasks.count > 0) {
                    return "View subtasks"
                } else {
                    return "Add subtasks"
                }
            },
            taskDate() {
                return this.dateTimeStringToDate(this.display_date);
            },
            taskListTypeSub() {
                return TASKS_TYPE.subtasks;
            },
            GET_USER_ID () {
                return this.$store.getters.GET_USER_ID;
            },
        },
        watch: {
            "subtasks": function(newVal, oldVal) {
                this.watchedSubtasks = newVal;
            }
        }
    }
</script>

<template>
    <div class="card card-default">
        <div class="card-header">
            <h3>{{ name }} <span class="fas fa-list"></span></h3>
        </div>
        <div class="card-body">
            <div>
                <!-- <b-button variant="secondary" v-if="!showSubTasks" @click.stop="showSubTasks = !showSubTasks">
                    {{ showSubTaskText }}
                    <i class="far fa-angle-double-down"></i>
                </b-button> -->

                <!-- <a
                        v-if="showSubTasks"
                        class="btn float-right my-auto"
                        title="Show Sub-tasks"
                        @click.stop="showSubTasks = !showSubTasks">
                    <i class="far fa-angle-double-up"></i>
                </a> -->
                <task-list
                    :tasks="watchedSubTasks"
                    title="Sub-Tasks"
                    @tasksUpdated="updateHandler($event, 'subTasks')"
                    @taskStatusChanged="changeSubTaskStatus($event)"
                    @taskNameChanged="updateHandler($event, 'name')"
                    @taskAdded="newSubTaskAdded($event)"
                    show-header="false"
                    :type="taskListTypeSub"
                    button-variant="primary"
                    button-size="sm"
                ></task-list>
            </div>

            <tags-component :taskTags="tags" @tagsUpdated="updateHandler($event, 'tags')"></tags-component>

        </div>
    </div>
</template>

<script>
    import {TASKS_TEMPLATE, TASK_GENERATOR, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE, TASKS_UTILITY} from '../config/tasks';
    import TaskList from "./TaskListComponent.vue";
    import TagsComponent from "./TagsComponent";
    export default {
        components: { TaskList, TagsComponent },
        props: ['name', 'status', 'expanded', 'subTasks', 'tags', 'id'],
        data() {
            return {
                'showSubTasks': false,
                'watchedSubTasks': [],
            }
        },
        mounted() {
            this.watchedSubTasks = _.cloneDeep(this.subTasks);
        },
        methods: {
            newSubTaskAdded($event) {
                let task = this.getNewTask();
                task.subTasks.push($event);
                this.updateParentTask(task);
            },
            getNewTask() {
                return TASK_GENERATOR(this.name, this.status, this.expanded, this.subTasks, this.tags, this.id);
            },
            changeSubTaskStatus($event) {
                let newSubTasks = _.cloneDeep(this.watchedSubTasks);
                if ($event.status == TASK_STATUS.selected) {
                    TASKS_UTILITY.select($event.index, newSubTasks);
                } else {
                    newSubTasks[$event.index].status = $event.status;
                }
                this.updateHandler(newSubTasks, "subTasks");
            },
            updateHandler($event, type) {
                let newTask = this.getNewTask();
                newTask[type] = $event;
                this.updateParentTask(newTask);
            },
            updateParentTask(task) {
                TASKS_EVENT.taskUpdated(this, task);
            },
        },
        computed: {
            showSubTaskText() {
                if (this.subTasks.count > 0) {
                    return "View sub-tasks"
                } else {
                    return "Add sub-tasks"
                }
            },
            taskListTypeSub() {
                return TASKS_TYPE.subTasks;
            },
            GET_USER_ID () {
                return this.$store.getters.GET_USER_ID;
            },
        },
        watch: {
            "subTasks": function(newVal, oldVal) {
                this.watchedSubTasks = newVal;
            }
        }
    }
</script>

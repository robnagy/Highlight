<template>
    <div class="card card-default">
        <div class="card-header" v-if="showHeader === 'true'">
            <h3 v-if="type == taskListTypeMain">{{ title }} <span class="fas fa-list"></span></h3>
            <h5 v-if="type == taskListTypeSub">{{ title }} <span class="fas fa-list"></span> </h5>
        </div>
        <div class="card-body">
            <div
                    v-for="(task,index) in tasks"
                    class="task-item container h-100"
                    :key="index"
            >
                <task-list-item
                        v-bind="task"
                        :index="index"
                        :type="type"
                        @taskStatusChanged="changeStatus(index, $event)"
                        @taskNameChanged="changeName(index, $event)"
                        @taskToggleExpanded="toggleExpanded()"
                        @dumpTasks="dump(tasks)"
                ></task-list-item>
            </div>
            <div class="addTask" v-if="showAddTasks">
                <b-form-input
                    v-model="newTaskName"
                    type="text"
                    :placeholder="createTaskText"
                    autocomplete="off"
                    @change="addTask"
                ></b-form-input>
                <!-- <b-button :variant="buttonVariant" :size="buttonSize" @click="addTask">{{ createTaskText }}</b-button> -->
                <span class="error">{{ taskNameError }}</span>
            </div>

        </div>
    </div>
</template>

<script>
    import {TASKS_TEMPLATE, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE} from '../config/tasks';
    import TaskListItem from './TaskListItemComponent';
    export default {
        props: ['tasks', 'title', 'type', 'showHeader', 'buttonVariant', 'buttonSize'],
        data() {
            return {
                "newTaskName": "",
                "subTaskStructure": {
                    "name": "",
                    "status": ""
                },
                "taskNameError": ""
            }
        },
        components: {
            TaskListItem
        },
        mounted() {},
        computed: {
            createTaskText() {
                if (this.type === TASKS_TYPE.main) {
                    return "Add a task";
                }
                return "Add a sub-task";
            },
            showAddTasks() {
                switch (this.type) {
                    case TASKS_TYPE.main:
                    case TASKS_TYPE.subTasks:
                        return true;
                    default: return false;
                }
            },
            taskListTypeMain() {
                return TASKS_TYPE.main;
            },
            taskListTypeSub() {
                return TASKS_TYPE.subTasks;
            },
        },
        methods: {
            addTask: function() {
               this.taskNameError = "";
               this.validateTaskName(this.newTaskName, () => {
                   let task = _.cloneDeep(TASKS_TEMPLATE);
                   task.name = this.newTaskName;
                   task.status = TASK_STATUS.new;
                   this.newTaskName = "";
                   this.taskNameError = "";
                   TASKS_EVENT.taskAdded(this, task);
               })
            },
            changeStatus: function(index, action) {
                TASKS_EVENT.taskStatusChanged(this, index, action);
            },
            changeName: function(index, action) {
                this.$emit('taskNameChanged', {index, 'name':action})
            },
            toggleExpanded: function() {
                TASKS_EVENT.taskToggleExpanded(this);
            },
            validateTaskName: function(name, callback) {
                let that = this;
                this.tasks.forEach(function(task){
                    if (task.name === name) {
                        that.taskNameError = "Task already exists";
                        return false;
                    }
                });
                if (name.length === 0) {
                    // that.taskNameError = "Task name too short";
                    return false;
                }
                callback(this);
            },
        }
    }
</script>

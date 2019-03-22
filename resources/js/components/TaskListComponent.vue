<template>
    <div class="tasks" :class="{ 'card-default': (showHeader === 'true'), 'card': (showHeader === 'true')}">
        <div class="card-header" v-if="showHeader === 'true'">
            <h3 v-if="type == taskListTypeMain">{{ title }} <span class="fas fa-list"></span></h3>
            <h5 v-if="type == taskListTypeSub">{{ title }} <span class="fas fa-list"></span> </h5>
        </div>
        <div  :class="{ 'card-body': (showHeader === 'true') }">
            <div
                    v-for="(task,index) in tasks"
                    class="task-item container h-100"
                    :key="index"
            >
            <transition-group name="task-list">
                <task-list-item
                        v-bind="task"
                        :index="index"
                        :type="type"
                        :key="index"
                        @taskDeleted="deletedTask(index, $event)"
                        @taskStatusChanged="changeStatus(index, $event)"
                        @taskNameChanged="changeName(index, $event)"
                        @taskToggleExpanded="toggleExpanded()"
                        @dumpTasks="dump(tasks)"
                ></task-list-item>
            </transition-group>
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
                "subtaskStructure": {
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
                return "Add a subtask";
            },
            showAddTasks() {
                switch (this.type) {
                    case TASKS_TYPE.main:
                    case TASKS_TYPE.subtasks:
                        return true;
                    default: return false;
                }
            },
            taskListTypeMain() {
                return TASKS_TYPE.main;
            },
            taskListTypeSub() {
                return TASKS_TYPE.subtasks;
            },
        },
        methods: {
            addTask() {
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
            changeStatus(index, action) {
                TASKS_EVENT.taskStatusChanged(this, index, action);
            },
            changeName(index, action) {
                this.$emit('taskNameChanged', {index, 'name':action})
            },
            deletedTask(index, $event) {
                this.$emit('taskDeleted', {index, 'id':$event.id})
            },
            toggleExpanded() {
                TASKS_EVENT.taskToggleExpanded(this);
            },
            validateTaskName(name, callback) {
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

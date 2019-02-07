<template>
    <div class="card card-default">
        <div class="card-header">
            <h3>{{ name }} <span class="fas fa-list"></span></h3>
        </div>
        <div class="card-body">
            <b-button variant="secondary" v-if="!showSubTasks" @click.stop="showSubTasks = !showSubTasks">
                {{ showSubTaskText }}
                <i class="far fa-angle-double-down"></i>
            </b-button>

            <a
                    v-if="showSubTasks"
                    class="btn float-right my-auto"
                    title="Show Sub-tasks"
                    @click.stop="showSubTasks = !showSubTasks">
                <i class="far fa-angle-double-up"></i>
            </a>
            <task-list v-if="showSubTasks"
                :tasks="watchedSubTasks"
                title="Sub-Tasks"
                @tasksUpdated="updateTasks($event)"
                @taskStatusChanged="changeSubTaskStatus($event)"
                @taskNameChanged="changeTaskName($event)"
                show-header="false"
                :type="taskListTypeSub"
                button-variant="primary"
                button-size="sm"
            ></task-list>

        </div>
    </div>
</template>

<script>
    import {TASKS_TEMPLATE, TASK_GENERATOR, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE} from '../config/tasks';
    import TaskList from "./TaskListComponent.vue"
    export default {
        components: {TaskList},
        props: ['name', 'status', 'expanded', 'subTasks'],
        data() {
            return {
                'showSubTasks': false,
                'watchedSubTasks': [],
            }
        },
        mounted() {
            console.log('Single task mounted.');
        },
        methods: {
            addSubTasks: () => {
                this.updateTasks([]);
            },
            changeSubTaskStatus($event) {
                console.log('singleTaskComponent subtask status changed '+$event.index+ " "+$event.status);
                let newSubTasks = _.cloneDeep(this.watchedSubTasks);
                newSubTasks[$event.index].status = $event.status;
                console.log('sub task status changed '+ $event.status+ " index is:"+$event.index);
                this.updateTasks(newSubTasks);
            },
            updateTasks($event) {
                console.log('SingleTaskComponent update tasks event received');
                console.log($event);
                let newTask = TASK_GENERATOR(this.name, this.status, this.expanded, $event);
                newTask.subTasks = $event;
                console.log('SingleTaskComponent task cloned');
                TASKS_EVENT.taskUpdated(this, newTask)
            }
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
            }
        },
        watch: {
            "subTasks": function(newVal, oldVal) {
                this.watchedSubTasks = newVal;
                console.log('Single task, parents sub-tasks changed');
            }
        }
    }
</script>

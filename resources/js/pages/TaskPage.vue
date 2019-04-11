<template>
    <div class="container">
        <div class="row justify-content-center">
            <task-header :previous="previous"
                :next="next"
                :otherTaskDates="otherTaskDates"
                :layout="layout"
                @changeLayout="setLayout($event)"
                @dateChanged="getTasksForDate($event)">
                </task-header>
        </div>
        <task-manager
            @showTasksChanged="showTasks = $event"
            :layout="layout"
            :tasksVisible="showTasks"
            :taskList="tasks">
        </task-manager>
    </div>
</template>

<script>
    import LoadTasksMixin from  '../mixins/loadTasksMixin';
    import TaskHeader from '../components/TaskHeaderComponent';
    import TaskManager from '../components/TaskManagerComponent';
    export default {
        data() {
            return {
                "firstLaunch": true,
                "layout": "vertical",
                "next": null,
                "otherTaskDates": [],
                "previous": null,
                "showTasks": false,
                "tasks": [],
                "title":"Tasks",
            }
        },
        components: {
            TaskHeader,
            TaskManager,
        },
        mixins: [ LoadTasksMixin ],
        created() {
            const layout = this.$cookies.get('tasks_layout');
            if (layout !== null) this.layout = layout;
        },
        mounted() {
            if (this.firstLaunch === true) {
                this.showTasks = true;
                this.firstLaunch = false;
            }
        },
        methods: {
            setLayout(event) {
                this.showTasks = false;
                setTimeout(() => {
                    this.$cookies.set('tasks_layout', event.layout);
                    this.layout = event.layout;
                    this.showTasks = true;
                }, 300);
            },
        },
    }
</script>

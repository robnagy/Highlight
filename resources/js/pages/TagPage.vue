<template>
    <div class="tags">
        <div class="row justify-content-center">
            <div class="tags-page title text">Tags</div>

        </div>
        <tag-list
            @hideTasks="hideTasks()"
            @showTasks="openTasks($event)"
            @tagChanged="tagChanged($event)"
        ></tag-list>
        <div v-if="showTasks">
            <hr>
            <task-manager
                layout="horizontal"
                :tasksVisible="showTasks"
                :taskList="tasks">
            </task-manager>
        </div>
    </div>
</template>

<script>
import LoadTasksMixin from  '../mixins/loadTasksMixin';
import TagList from '../components/tags/TagListComponent';
import TaskManager from '../components/TaskManagerComponent';
export default {
    components: { TagList, TaskManager },
    mixins: [ LoadTasksMixin ],
    data() {
        return {
            showTasks: false,
            tasks: [],
        }
    },
    methods: {
        hideTasks($event) {
            this.showTasks = false;
        },
        openTasks($event) {
            // this.showTasks = false;
            this.getTasksForTag($event);
        },
        tagChanged($event) {
            if (this.showTasks) {
                this.openTasks($event);
            }
        }
    }
}
</script>


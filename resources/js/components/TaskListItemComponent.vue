<template>
    <div class="row align-items-center h-100"
        @click.stop="markSelected"
        :class="taskClass"
        title="Click to select"
        @mouseenter="hover = true"
        @mouseleave="hover = false"
        >
        <div class="col-md-5" v-if="!editMode">
            <span class="float-left m-1 p-1" :class="taskClass">{{ localName }}</span>
        </div>
        <div class="col-md-5" v-if="editMode" @click.stop="">
            <span class="float-left" :class="taskClass"><input type="text" v-model="localName" ></span>
        </div>
        <div class="col-md-7" v-if="hover">
            <a
                    v-if="showExpand"
                    class="btn float-right"
                    :class="taskClass"
                    title="Expand task"
                    @click.stop="markExpanded">
                <i class="far fa-angle-double-right"></i>
            </a>
            <a
                    v-if="showContract"
                    class="btn float-right"
                    :class="taskClass"
                    title="Expand task"
                    @click.stop="markExpanded">
                <i class="far fa-angle-double-left"></i>
            </a>
            <a
                    v-if="showDelete"
                    class="btn float-right"
                    :class="taskClass"
                    title="Delete task"
                    @click.stop="markDeleted">
                <i class="far fa-trash"></i>
            </a>
            <a
                    v-if="showMarkComplete"
                    class="btn float-right my-auto"
                    :class="taskClass"
                    title="Mark as complete"
                    @click.stop="markComplete">
                <i class="far fa-check"></i>
            </a>
            <a
                    v-if="showEdit"
                    class="btn float-right my-auto"
                    :class="taskClass"
                    title="Edit"
                    @click.stop="markEditing">
                <i class="far fa-edit"></i>
            </a>
            <a
                    v-if="showEditSave"
                    class="btn float-right my-auto"
                    :class="taskClass"
                    title="Save"
                    @click.stop="saveName">
                <i class="far fa-save"></i>
            </a>
            <a
                    v-if="showEditCancel"
                    class="btn float-right my-auto"
                    :class="taskClass"
                    title="Cancel"
                    @click.stop="markSelected">
                <i class="far far-undo-alt"></i>
            </a>
            <a
                    v-if="showReopenTask"
                    class="btn float-right"
                    :class="taskClass"
                    title="Reopen task"
                    @click.stop="markNew">
                <i class="far far-lock-open"></i>
            </a>
            </a>
        </div>
    </div>
</template>

<script>
    import {TASKS_TEMPLATE, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE} from '../config/tasks';
    export default {
        props: ['name', 'status', 'type', 'expanded', 'subTasks'],
        data() {
            return {
                localName: "",
                hover: false,
            }
        },
        mounted() {
            this.localName = this.name;
        },
        computed: {
            editMode() {
                switch (this.status) {
                    case TASK_STATUS.editing:
                        return true;
                    default:
                        return false;
                }
            },
            showDelete() {
                switch (this.status) {
                    case TASK_STATUS.editing:
                        return false;
                    default:
                        return true;
                }
            },
            showEdit() {
                switch (this.status) {
                    case TASK_STATUS.selected:
                        return true;
                    default:
                        return false;
                }
            },
            showEditCancel() {
                switch (this.status) {
                    case TASK_STATUS.editing:
                        return true;
                    default:
                        return false;
                }
            },
            showEditSave() {
                switch (this.status) {
                    case TASK_STATUS.editing:
                        return true;
                    default:
                        return false;
                }
            },
            showExpand() {
                switch (this.status) {
                    case TASK_STATUS.selected:
                        if (this.type == TASKS_TYPE.main)
                            return this.expanded === false;
                    default:
                        return false;
                }
            },
            showContract() {
                switch (this.status) {
                    case TASK_STATUS.selected:
                        return this.expanded === true;
                    default:
                        return false;
                }
            },
            showMarkComplete() {
                switch (this.status) {
                    case TASK_STATUS.selected:
                        return true;
                    default:
                        return false;
                }
            },
            showReopenTask() {
                switch (this.status) {
                    case TASK_STATUS.completed:
                        return true;
                    default:
                        return false;
                }
            },
            taskClass() {
                return "task-"+this.status
            }
        },
        methods: {
            markComplete() {
                this.statusChanged(TASK_STATUS.completed);
            },
            markDeleted() {
                this.statusChanged(TASK_STATUS.deleted);
            },
            markNew() {
                this.statusChanged(TASK_STATUS.new);
            },
            markEditing() {
                this.statusChanged(TASK_STATUS.editing);
            },
            markExpanded() {
                TASKS_EVENT.taskToggleExpanded(this);
            },
            markSelected() {
                this.statusChanged(TASK_STATUS.selected);
            },
            saveName() {
                this.$emit('taskNameChanged', this.localName);
                this.statusChanged(TASK_STATUS.selected);
            },
            statusChanged(status) {
                this.$emit('taskStatusChanged', status);
            }
        },
        watch: {
            name(newValue) {
                this.localName = newValue;
            }
        }
    }
</script>

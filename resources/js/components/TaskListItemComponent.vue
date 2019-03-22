<template>
    <div class="row align-items-center h-100 task-list-item"
        @click.stop="markSelected"
        :class="taskClass"
        title="Click to select"
        @mouseenter="setHover(true)"
        @mouseleave="setHover(false)"
        >
        <div class="col-md-5" v-if="!editMode">
            <span class="float-left text-left m-1 p-1" :class="taskClass">{{ localName }}</span>
        </div>
        <div class="col-md-5" v-if="editMode" @click.stop="">
            <span class="float-left" :class="taskClass">
                <b-form-input
                    :id="editId"
                    type="text"
                    v-model="localName"
                    @change="saveName">
                </b-form-input>
            </span>
        </div>
        <div class="col-md-7" v-if="hover">
            <a
                    v-if="showExpand"
                    class="btn float-right"
                    :class="taskClass"
                    title="Expand task"
                    @click.stop="markExpanded">
                <i class="fas fa-angle-double-right"></i>
            </a>
            <a
                    v-if="showContract"
                    class="btn float-right"
                    :class="taskClass"
                    title="Collapse task"
                    @click.stop="markExpanded">
                <i class="fas fa-angle-double-left"></i>
            </a>
            <a
                    v-if="showDelete"
                    class="btn float-right"
                    :class="taskClass"
                    title="Delete task"
                    @click.stop="deleted">
                <i class="fas fa-trash"></i>
            </a>
            <a
                    v-if="showMarkComplete"
                    class="btn float-right my-auto"
                    :class="taskClass"
                    title="Mark as complete"
                    @click.stop="markComplete">
                <i class="fas fa-check"></i>
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
                <i class="far fa-edit"></i>
            </a>
            </a>
        </div>
    </div>
</template>

<script>
    import {TASKS_TEMPLATE, TASK_STATUS, TASKS_EVENT_NAME, TASKS_EVENT, TASKS_TYPE} from '../config/tasks';
    export default {
        props: ['name', 'status', 'type', 'expanded', 'subtasks', 'id'],
        data() {
            return {
                editing: false,
                localName: "",
                hover: false,
                isTouch: false,
            }
        },
        mounted() {
            this.localName = this.name;
            this.isTouch = document.hasTouchSupport;
        },
        computed: {
            editId() {
                return "task_name_edit_"+this.id;
            },
            editMode() {
                return this.editing;
            },
            showDelete() {
                if (this.editMode) return false;
                switch (this.status) {
                    case TASK_STATUS.editing:
                        return false;
                    default:
                        return true;
                }
            },
            showEdit() {
                if (this.editMode) return false;
                switch (this.status) {
                    case TASK_STATUS.selected:
                        return true;
                    default:
                        return false;
                }
            },
            showEditCancel() {
                if (this.editMode) return true;
                return false;
            },
            showEditSave() {
                if (this.editMode) return true;
                return false;
            },
            showExpand() {
                if (this.editMode) return false;
                switch (this.status) {
                    case TASK_STATUS.selected:
                        if (this.type == TASKS_TYPE.main) {
                            return this.expanded == false;
                        }
                    default:
                        return false;
                }
            },
            showContract() {
                if (this.editMode) return false;
                switch (this.status) {
                    case TASK_STATUS.selected:
                        return this.expanded == true;
                    default:
                        return false;
                }
            },
            showMarkComplete() {
                if (this.editMode) return false;
                switch (this.status) {
                    case TASK_STATUS.selected:
                        return true;
                    default:
                        return false;
                }
            },
            showReopenTask() {
                if (this.editMode) return false;
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
            deleted() {
                this.$emit('taskDeleted', {'id':this.id});
            },
            markComplete() {
                this.statusChanged(TASK_STATUS.completed);
            },
            markNew() {
                this.statusChanged(TASK_STATUS.new);
            },
            markEditing() {
                this.editing = true;
                // this.statusChanged(TASK_STATUS.editing);
            },
            markExpanded() {
                TASKS_EVENT.taskToggleExpanded(this);
            },
            markSelected() {
                this.statusChanged(TASK_STATUS.selected);
            },
            saveName() {
                this.editing = false;
                this.$emit('taskNameChanged', this.localName);
            },
            setHover(hover) {
                this.hover = this.isTouch ? true : hover;
            },
            statusChanged(status) {
                this.$emit('taskStatusChanged', status);
            }
        },
        watch: {
            name(newValue) {
                this.localName = newValue;
            },
            status(newValue) {
                if (newValue == TASK_STATUS.editing) {
                    this.$nextTick(() => {
                        let el = document.getElementById(this.editId);
                        el.focus();
                    })
                }
            }
        }
    }
</script>

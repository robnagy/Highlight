<template>
    <div class="task-page-header">
        <div class="task-page title">
            <div class="spacer-5"></div>
            <div class="task-page-date-selector" v-if="previous" @click.stop="setDate(previous)">
                <i class="fas fa-chevron-circle-left" :title="previous"></i>
            </div>
            <div class="spacer-2" v-if="!previous"></div>
            <div class="task-page title text">
                {{ title }}
            </div>
            <div class="task-page-date-selector" v-if="nextDate" @click.stop="setDate(nextDate)">
                <i class="fas fa-chevron-circle-right" :title="nextDate"></i>
            </div>
            <div class="spacer-2" v-if="!nextDate"></div>
            <div class="task-page selectors">
                <div class="task-layout-selector" :class="verticalSelectorClass" @click.stop="setLayout('vertical')">
                    <i class="fas fa-grip-vertical"></i>
                </div>
                <div class="task-layout-selector" :class="horizontalSelectorClass" @click.stop="setLayout('horizontal')">
                    <i class="fas fa-grip-horizontal"></i>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { TASKS_EVENT } from '../config/tasks';
    export default {
        props: ["layout", "previous", "next"],
        data() {
            return {
                date: null,
            }
        },
        mounted() {
            this.date = this.today;
            console.log(this.date);
        },
        computed: {
            horizontalSelectorClass() {
                if (this.layout === "horizontal") {
                    return "selected";
                } else {
                    return "not-selected";
                };
            },
            nextDate() {
                if (this.next === null && this.date !== this.today) {
                    return this.today;
                }
                return this.next;
            },
            title() {
                if (this.date !== null) {
                    let dateParts = this.date.split('-');
                    let d = new Date(dateParts[0], dateParts[1] -1, dateParts[2]);
                    if (this.formatDate(d) !== this.today) {
                        return d.toDateString();
                    } else {
                        return "Today";
                    }
                }
                return "Loading";
            },
            today() {
                let d = new Date;
                return this.formatDate(d);
            },
            verticalSelectorClass() {
                if (this.layout === "vertical") {
                    return "selected";
                } else {
                    return "not-selected";
                };
            },
        },
        methods: {
            formatDate(d) {
                return d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
            },
            setDate(date) {
                this.date = date;
            },
            setLayout(layout) {
                this.$emit('changeLayout', { layout })
            }
        },
        watch: {
            date(newValue, oldValue) {
                TASKS_EVENT.tasksPageDateChanged(this, newValue);
            }
        }
    }
</script>

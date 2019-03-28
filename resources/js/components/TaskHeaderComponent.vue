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
                <div class="task-page date-dropdown" v-if="showDatePicker">
                    <datepicker
                        :inline="true"
                        :highlighted="highlightedDates"
                        :value="selectedDateObject"
                        @selected="changeDate($event)"
                    ></datepicker>
                </div>
                <div class="task-layout-selector" @click.stop="showDatePicker = true">
                    <i class="far fa-calendar-alt"></i>
                </div>
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
    import Datepicker from 'vuejs-datepicker';
    import datesMixin from '../mixins/datesMixin.js'
    export default {
        props: ["layout", "previous", "next", "otherTaskDates"],
        components: { Datepicker },
        mixins: [ datesMixin ],
        data() {
            return {
                date: null,
                showDatePicker: false,

            }
        },
        mounted() {
            this.date = this.today;
        },
        computed: {
            highlightedDates() {
                let dates = [];
                this.otherTaskDates.forEach((date) => {
                    dates.push(this.dateStringToObject(date));
                });
                return {dates};
            },
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
            selectedDateObject() {
                if (this.date !== null) {
                    return this.dateStringToObject(this.date);
                } else {
                    return new Date();
                }
            },
            title() {
                if (this.date !== null) {
                    let d = this.dateStringToObject(this.date);
                    if (this.formatDate(d) !== this.today) {
                        return d.toDateString();
                    } else {
                        return "Today";
                    }
                }
                return "Loading";
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

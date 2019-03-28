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
    export default {
        props: ["layout", "previous", "next"],
        components: { Datepicker },
        data() {
            return {
                date: null,
                showDatePicker: false,

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
            selectedDateObject() {
                let d = new Date();
                if (this.date !== null) {
                    let dArray = this.date.split('-');
                    d.setFullYear = dArray[0];
                    d.setMonth = dArray[1] -1;
                    d.setDate = dArray[2];
                }
                return d;
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
            changeDate(dateObject) {
                this.showDatePicker = false;
                console.log("change date");
                console.log(dateObject);
                this.date = this.formatDate(dateObject);
            },
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

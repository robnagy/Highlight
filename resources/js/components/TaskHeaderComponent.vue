<template>
    <div class="task-page-header">
        <div class="task-page title">
            <div class="task-page title text">Today</div>
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
</template>

<script>
    export default {
        props: ["layout"],
        mounted() {},
        computed: {
            horizontalSelectorClass() {
                if (this.layout === "horizontal") {
                    return "selected";
                } else {
                    return "not-selected";
                };
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
        }
    }
</script>

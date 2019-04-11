<template>
    <b-button
        :variant="variant"
        @click="toggleActive()"
        size="sm"
    >
        {{ text }}
        <b-badge pill variant="secondary" v-if="tasks_count > 0">{{ tasks_count }}</b-badge>
    </b-button>
</template>
<script>
export default {
    props: ['text', 'tasks_count', 'active'],
    computed: {
        variant() {
            if (this.active) {
                return "info"
            } else {
                return "outline-dark"
            }
        }
    },
    methods: {
        toggleActive() {
            if (this.active) {
                this.$emit('unsetActive');
            } else {
                this.$emit('setActive');
            }
        }
    },
}
</script>

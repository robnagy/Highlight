<template>
    <div v-if="!isEditing" @dblclick="isEditing = true">{{ text }}</div>
    <div v-else>
        <label for="tag-input">Tag:</label>
        <b-form-input
            id="tag-input"
            v-model="tagText"
            :state="textState"
            @change="textUpdated($event)"
        ></b-form-input>

        <b-form-invalid-feedback id="tag-input-feedback">
            Enter at least 2 letters
        </b-form-invalid-feedback>
    </div>
</template>

<script>
export default {
    props: ['id', 'text', 'index'],
    data() {
        return {
            tagText: '',
            isEditing: false
        }
    },
    created() {
        this.tagText = this.text;
    },
    methods: {
        textUpdated($event) {
            this.$emit('tagTextUpdated', $event);
            this.isEditing = false;
        }
    },
    computed: {
      textState() {
        return this.tagText.length > 1 ? true : false
      }
    },
}
</script>

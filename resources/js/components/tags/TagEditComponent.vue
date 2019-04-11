<template>
    <div class="align-items-center tag-list-item h-100">
        <div class="row">
            <b-form-input
                id="tag-input"
                class="col-md-10"
                v-model="tagText"
                @keyup.native="checkKey"
            ></b-form-input>
            <div class="tag-cancel-edit col-md-2">
                <b-button
                    variant="success"
                    size="sm"
                >
                    <a
                        v-if="true"
                        class="tag-btn btn float-right"
                        title="Save tag"
                        @click.stop="saveTag">
                        <i class="fas fa-save"></i>
                    </a>
                </b-button>

        </div>
        </div>


    </div>
</template>

<script>
export default {
    props: ['id', 'text', 'index'],
    data() {
        return {
            hover: false,
            isEditing: false,
            tagText: '',
        }
    },
    created() {
        this.tagText = this.text;
        this.isTouch = document.hasTouchSupport;
        if (this.isTouch) this.setHover();
    },
    methods: {
        checkKey(e) {
            if (e.key === "Enter") {
                this.$emit('tagTextUpdated', this.tagText);
            }
        },
        setHover(hover) {
            this.hover = this.isTouch ? true : hover;
        },
        saveTag($event) {
            this.$emit('tagTextUpdated', this.tagText);
            // this.isEditing = false;
        }
    },
    computed: {
      textState() {
        return this.tagText.length > 1 ? true : false
      }
    },
}
</script>

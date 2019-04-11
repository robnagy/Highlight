<template>
    <div>
        <div class="row justify-content-center">
            <div class="tags-list">
                <tag-list-item-button
                    v-for="(tag,index) in allTags"
                    :key="index"
                    v-bind="tag"
                    :active="index === activeIndex"
                    @setActive="setActiveTag(index)"
                    @tagTextUpdated="updateTagText($event, index)"
                    @unsetActive="setActiveTag(null)">
                </tag-list-item-button>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center" v-if="activeIndex !== null">
            <div class="row">
                <b-button variant="outline-danger" @click="editing = !editing">
                    Edit Tag
                </b-button>
                <b-button variant="outline-secondary" @click="showTasks">
                    View Tasks
                </b-button>
            </div>
        </div>
        <div class="row justify-content-center" v-if="editing">
            <tag-edit v-bind="selectedTag" @tagTextUpdated="updateTagText($event, activeIndex)"></tag-edit>
        </div>
    </div>
</template>

<script>
import loadTagsMixin from '../../mixins/loadTagsMixin';
import saveTagsMixin from '../../mixins/saveTagsMixin';
import TagEdit from './TagEditComponent';
import TagListItemButton from './TagListItemButton';
export default {
    mixins: [ loadTagsMixin, saveTagsMixin ],
    components: { TagEdit, TagListItemButton },
    data() {
        return {
            activeIndex: null,
            allTags: [],
            editing: false,
            showingTasks: false,
        }
    },
    created() {
        this.fetchUserTags();
    },
    computed: {
        selectedTag() {
            if (this.activeIndex !== null)
                return this.allTags[this.activeIndex];
        }
    },
    methods: {
        setActiveTag(index) {
            this.activeIndex = index;
        },
        showTasks() {
            this.showingTasks = !this.showingTasks;
            if (this.showingTasks === true) {
                let tag = this.allTags[this.activeIndex];
                this.$emit("showTasks", tag);
            } else {
                this.$emit("hideTasks");
            }
        },
        updateTagText($event, index) {
            this.editing = false;
            let tag = _.clone(this.allTags[index]);
            tag.text = $event;
            this.postTag(tag, (tag) => { this.tagUpdated(tag, index)});
        },
        tagUpdated(tag, index) {
            this.$set(this.allTags, index, tag);
        },
    },
    watch: {
        activeIndex(val) {
            if (val === null) {
                this.showTasks = false;
            } else {
                this.$emit('tagChanged', this.allTags[val]);
            }
            this.editing = false;
        },
    }
}
</script>

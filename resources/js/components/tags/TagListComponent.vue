<template>
    <div class="card card-default">
        <b-list-group>
            <b-list-group-item
                v-for="(tag,index) in allTags"
                :key="index"
                >
                <tag-list-item v-bind="tag" @tagTextUpdated="updateTagText($event, index)"></tag-list-item>
            </b-list-group-item>
        </b-list-group>
    </div>
</template>

<script>
import loadTagsMixin from '../../mixins/loadTagsMixin';
import saveTagsMixin from '../../mixins/saveTagsMixin';
import TagListItem from './TagListItemComponent';
export default {
    mixins: [ loadTagsMixin, saveTagsMixin ],
    components: { TagListItem },
    data() {
        return {
            allTags: []
        }
    },
    created() {
        this.fetchUserTags();
    },
    methods: {
        updateTagText($event, index) {
            let tag = _.clone(this.allTags[index]);
            tag.text = $event;
            this.postTag(tag, (tag) => { this.tagUpdated(tag, index)});
        },
        tagUpdated(tag, index) {
            this.$set(this.allTags, index, tag);
        },
    }
}
</script>

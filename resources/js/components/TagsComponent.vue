<template>
    <div class="m-2">
        <vue-tags-input
            class="task-tags mx-auto"
            v-model="tag"
            :tags="activeTags"
            :autocomplete-items="allTags"
            :allow-edit-tags="false"
            :avoid-adding-duplicates="true"
            @before-adding-tag="onTagAdded"
            @before-deleting-tag="onTagRemoved"
        >
        </vue-tags-input>
    </div>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';
    import NetworkClient from '../utils/network_client.js';
    import api from '../config/api.js';
import { timeout } from 'q';
    export default {
        components: { VueTagsInput },
        props: [ 'taskTags' ],
        data() {
            return {
                'activeTags' : [],
                'allTags' : [],
                'tag' : "",
            }
        },
        mounted() {
            this.activeTags = _.cloneDeep(this.taskTags);
            this.fetchUserTags();
        },
        methods: {
            fetchUserTags() {
                this.errorState = false;
                NetworkClient.request(api.v1.get.tags, null, null, null, this.fetchUserTagsSuccess, this.fetchUserTagsError);
            },
            fetchUserTagsSuccess(data, url) {
                this.allTags = data;
            },
            fetchUserTagsError(e, url) {
                this.errorState = true;
            },
            onTagAdded($event) {
                if (!$event.tag.tiClasses.includes("ti-duplicate")) {
                    let newActiveTags = _.cloneDeep(this.activeTags);
                    newActiveTags.push(_.cloneDeep($event.tag));
                    this.activeTags = newActiveTags;
                    if (!$event.tag.hasOwnProperty("id"))
                        this.saveTagOnline($event.tag)
                } else {
                    console.log('duplicate tag not added');
                }
                this.tag = "";
            },
            onTagRemoved($event) {
                // remove tag from task tags
                let remove = null;
                this.activeTags.forEach((tag, index) => {
                    if (tag.text === $event.tag.text) {
                        remove = index;
                        return;
                    }
                });
                this.activeTags.splice(remove, 1);
            },
            saveTagOnline(tag) {
                // save tag online, link to task
                NetworkClient.request(api.v1.post.tag, tag, null, null, this.saveTagSuccess, this.fetchUserTagsError);
            },
            saveTagSuccess(data) {
                // add new tag to task tags
                this.activeTags.forEach(tag => {
                    if (tag.text === data.text) {
                        Object.assign(tag, data);
                    }
                });
            },
            saveTagError(e) {
                console.log(e);
            },
            userTagsReceived($event) {
                this.allTags = $event;
            },
            exportTags() {
                let newTags = _.cloneDeep(this.activeTags);
                this.$emit('tagsUpdated', newTags);
            }
        },
        watch:{
            activeTags() {
                if (!_.isEqual(this.activeTags, this.taskTags)) {
                    this.exportTags();
                }
            },
            taskTags() {
                if (!_.isEqual(this.activeTags, this.taskTags)) {
                    this.activeTags = _.cloneDeep(this.taskTags);
                }
            }
        }
    }
</script>

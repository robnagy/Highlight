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
    import saveTagsMixin from '../mixins/saveTagsMixin';
    import NetworkClient from '../utils/network_client.js';
    import api from '../config/api.js';

    export default {
        components: { VueTagsInput },
        props: [ "taskid" ],
        mixins: [ saveTagsMixin ],
        data() {
            return {
                'activeTags' : [],
                'allTags' : [],
                'tag' : "",
            }
        },
        mounted() {
            // this.activeTags = _.cloneDeep(this.taskTags || []);
            this.fetchUserTags();
            this.fetchTaskTags();
        },
        methods: {
            fetchTaskTags() {
                let placeholders = { "__taskid__" : this.taskid };
                NetworkClient.request(api.v1.get.tagTask, null, placeholders, null, this.fetchTaskTagsSuccess, this.fetchTaskTagsError);
            },
            fetchTaskTagsSuccess(response, url) {
                this.activeTags = response.data;
            },
            fetchTaskTagsError(response, url) {
                console.log('Fetch task tags error for url '+url);
                console.log(response);
            },
            fetchUserTags() {
                NetworkClient.request(api.v1.get.tags, null, null, null, this.fetchUserTagsSuccess, this.fetchUserTagsError);
            },
            fetchUserTagsSuccess(data, url) {
                this.allTags = data;
            },
            fetchUserTagsError(e, url) {
                this.errorState = true;
            },
            linkTagTask(tag_id) {
                let placeholders = {"__taskid__" : this.taskid, "__tagid__" : tag_id};
                NetworkClient.request(api.v1.get.tagTaskLink, null, placeholders, null, this.linkTagTaskSuccess, this.linkTagTaskError)
            },
            linkTagTaskSuccess(response, url) {
                // console.log("Link tag task success for "+url);
            },
            linkTagTaskError(response, url) {
                console.log("Link tag task error for "+url);
                console.log(response);
            },
            onTagAdded($event) {
                if (!$event.tag.tiClasses.includes("ti-duplicate")) {
                    // if tag is manually typed in, and already exists, replace with actual tag
                    this.allTags.forEach((tag) => {
                        if (tag.text == $event.tag.text)
                            $event.tag = tag;
                    })
                    let newActiveTags = _.cloneDeep(this.activeTags);
                    newActiveTags.push(_.cloneDeep($event.tag));
                    this.activeTags = newActiveTags;
                    if ($event.tag.hasOwnProperty("id")) {
                        this.linkTagTask($event.tag.id);
                    } else {
                        // link new tag to task
                        let callback = (result) => {
                            this.linkTagTask(result.data.id);
                        }
                        this.saveTagOnline($event.tag, callback);
                    }
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
                this.unlinkTagTask($event.tag.id);
            },

            unlinkTagTask(tag_id) {
                let placeholders = {"__taskid__" : this.taskid, "__tagid__" : tag_id};
                NetworkClient.request(api.v1.get.tagTaskUnlink, null, placeholders, null, this.unlinkTagTaskSuccess, this.unlinkTagTaskError)
            },
            unlinkTagTaskSuccess(response, url) {
                // console.log("unlink tag task success for "+url);
            },
            unlinkTagTaskError(response, url) {
                console.log("unlink tag task error for "+url);
                console.log(response);
            },
            userTagsReceived($event) {
                this.allTags = $event;
            },
        },
        watch:{
            taskid() {
                this.activeTags = [];
                this.fetchTaskTags();
            }
        }
    }
</script>

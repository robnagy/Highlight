import api from "../config/api"
import NetworkClient from "../utils/network_client"
export default {
    data() {
        return {};
    },
    methods: {
        postTask(data, index) {
            if (data.hasOwnProperty('id'))
                this.postUpdatedTask(data, index);
            else
                this.postNewTask(data, index);
        },
        postNewTask(data, index) {
            let onSuccess = (d, url) => this.postTaskSuccess(d, index, url);
            let onFailure = (e, url) => this.postTaskFailure(e, index, url);
            NetworkClient.request(api.v1.post.task, data, null, null, onSuccess, onFailure);
        },
        postUpdatedTask(data, index) {
            let onSuccess = (d, url) => this.postTaskSuccess(d, index, url);
            let onFailure = (e, url) => this.postTaskFailure(e, index, url);
            let placeholders = { "__id__" : data.id };
            NetworkClient.request(api.v1.patch.task, data, placeholders, null, onSuccess, onFailure);
        },
        postTaskSuccess(response, index, url) {
            if (index !== null) {
                this.$set(this.tasks, index, response.data);
            }
        },
        postTaskFailure(response, index, url) {
            console.log("POST task failed for index "+index+" for url "+url);
            console.log(response);
        },
        postTaskTrigger() {
            this.postTask(this.tasks[this.selectedTaskIndex], this.selectedTaskIndex);
        },
    }
}

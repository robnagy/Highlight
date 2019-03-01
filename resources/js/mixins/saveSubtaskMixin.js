import api from "../config/api"
import NetworkClient from "../utils/network_client"
export default {
    data() {
        return {};
    },
    methods: {
        postSubtask(data, index) {
            if (data.hasOwnProperty('id'))
                this.patchSubtask(data, index);
            else
                this.postNewSubtask(data, index);
        },
        postNewSubtask(data, index) {
            let onSuccess = (d, url) => this.postSubtaskSuccess(d, index, url);
            let onFailure = (e, url) => this.postSubtaskFailure(e, index, url);
            let placeholders = { "__taskid__" : this.id };
            NetworkClient.request(api.v1.post.subtask, data, placeholders, null, onSuccess, onFailure);
        },
        patchSubtask(data, index) {
            let onSuccess = (d, url) => this.postSubtaskSuccess(d, index, url);
            let onFailure = (e, url) => this.postSubtaskFailure(e, index, url);
            let placeholders = { "__subtaskid__" : data.id, "__taskid__" : this.id };
            NetworkClient.request(api.v1.patch.subtask, data, placeholders, null, onSuccess, onFailure);
        },
        postSubtaskSuccess(response, index, url) {
            this.$set(this.subtasks, index, response.data);
        },
        postSubtaskFailure(error, index, url) {
            console.log("POST subtask failed for index "+index+" for url "+url);
            console.log(error);
        },
    }
}

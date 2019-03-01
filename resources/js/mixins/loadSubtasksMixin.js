import NetworkClient from '../utils/network_client'
import api from '../config/api'

export default {
    data() {
        return {};
    },
    created() {
        this.triggerLoadSubTasks();
    },
    methods: {
        subtasksGetSuccess(data) {
            this.subtasks = data;
        },
        subtasksGetFailure(e, url) {
            console.log(e);
            console.log(url);
        },
        triggerLoadSubTasks() {
            let placeholders = { '__taskid__' : this.id };
            NetworkClient.request(api.v1.get.subtasks, null, placeholders, null, this.subtasksGetSuccess, this.subtasksGetFailure);
        },
    },
    watch: {
        id(older, newer) {
            this.subtasks = [];
            this.triggerLoadSubTasks();
        }
    }
}

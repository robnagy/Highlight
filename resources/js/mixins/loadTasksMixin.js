import NetworkClient from '../utils/network_client'
import api from '../config/api'

export default {
    data() {
        return {};
    },
    created() {
        NetworkClient.request(api.v1.get.tasks, null, null, null, this.tasksGetSuccess, this.tasksGetFailure);
    },
    methods: {
        tasksGetSuccess(data) {
            this.tasks = data.data;
            this.updateSelectedTaskIndex();
        },
        tasksGetFailure(e, url) {
            console.log(e);
            console.log(url);
        }
    }
}

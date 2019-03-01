import NetworkClient from '../utils/network_client';
import api from '../config/api';

export default {
    methods: {
        deleteTask(task_id, index) {
            let onSuccess = (data, url) => { this.deleteTaskSuccess(data, url, index) };
            let onFailure = (error, url) => { this.deleteTaskFailure(error, url, index) };
            let placeHolders = { '__taskid__': task_id };
            NetworkClient.request(api.v1.delete.task, null, placeHolders, null, onSuccess, onFailure);
        },
        deleteTaskSuccess(data, url, index) {
            this.tasks.splice(index, 1);
        },
        deleteTaskFailure(error, url, index) {
            console.log('task delete failure, index:'+index+ ', url:'+url);
        },
    }
}

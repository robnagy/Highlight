import api from '../config/api';
import NetworkClient from '../utils/network_client';

export default {
    methods: {
        deleteSubtask(data, task_id) {
            let onSuccess = (result, url) => {this.deleteOnSuccess(result, url, data.index)};
            let onFailure = (result, url) => {this.deleteOnError(result, url, data.index)};
            let placeholders = {'__taskid__': task_id, '__subtaskid__': data.id};
            NetworkClient.request(api.v1.delete.subtask, null, placeholders, null, onSuccess, onFailure);
        },
        deleteOnSuccess(data, url, index) {
            if (data) {
                this.subtasks.splice(index, 1);
            }
        },
        deleteOnError(error, url, index) {
            // display error?
            console.log('onDeleteFailure triggered for index '+index+' at url '+url+' '+error);
        }
    }
}

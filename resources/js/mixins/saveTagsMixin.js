import NetworkClient from '../utils/network_client'
import api from '../config/api'

export default {
    methods: {
        saveTagOnline(tag, callback) {
            // save tag online
            let onSuccess = (result, url) => { this.saveTagSuccess(result, url, callback) }
            NetworkClient.request(api.v1.post.tag, tag, null, null, onSuccess, this.saveTagError);
        },
        saveTagSuccess(result, url, callback) {
            // add new tag to task tags
            this.activeTags.forEach(tag => {
                if (tag.text === result.data.text) {
                    Object.assign(tag, result.data);
                }
            });
            if (callback) callback(result);
        },
        saveTagError(e, url) {
            console.log("Error saving tag at url:"+url);
            console.log(e);
        },
    }
}

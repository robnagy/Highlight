import NetworkClient from '../utils/network_client'
import api from '../config/api'

export default {
    methods: {
        postTag(data, callback) {
            if (data.hasOwnProperty('id'))
                this.postUpdatedTag(data, callback); //callback should update tag in tag array with result
            else
                this.saveTagOnline(data, callback); //callback should push result to tag array
        },
        postUpdatedTag(tag, callback) {
            let onSuccess = (result, url) => { this.saveTagSuccess(result, url, callback) }
            let placeholder = { '__tagid__': tag.id };
            NetworkClient.request(api.v1.patch.tag, tag, placeholder, null, onSuccess, this.saveTagError);
        },
        saveTagOnline(tag, callback, index) {
            // save tag online
            let onSuccess = (result, url) => { this.saveTagSuccess(result, url, callback, index) }
            NetworkClient.request(api.v1.post.tag, tag, null, null, onSuccess, this.saveTagError);
        },
        saveTagSuccess(result, url, callback) {
            // add new tag to task tags
            if (this.activeTags) {
                this.activeTags.forEach(tag => {
                    if (tag.text === result.data.text) {
                        Object.assign(tag, result.data);
                    }
                });
            }
            if (callback) callback(result);
        },
        saveTagError(e, url) {
            console.log("Error saving tag at url:"+url);
            console.log(e);
        },
    }
}

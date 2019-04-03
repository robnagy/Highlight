import NetworkClient from '../utils/network_client'
import api from '../config/api'

export default {
    methods: {
        fetchUserTags() {
            NetworkClient.request(api.v1.get.tags, null, null, null, this.fetchUserTagsSuccess, this.fetchUserTagsError);
        },
        fetchUserTagsSuccess(data, url) {
            this.allTags = data;
        },
        fetchUserTagsError(e, url) {
            console.log('Error fetching tags from '+url);
        },
    }
}

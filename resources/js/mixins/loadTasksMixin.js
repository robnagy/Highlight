import NetworkClient from '../utils/network_client'
import api from '../config/api'

export default {
    data() {
        return {
            date: null,
        };
    },
    created() {

    },
    methods: {
        getTasks({date}) {
            this.selectedTaskIndex = null;
            this.date = date;
            const placeholders = { '__date__' : date };
            NetworkClient.request(api.v1.get.tasks, null, placeholders, null, this.tasksGetSuccess, this.tasksGetFailure);
        },
        tasksGetSuccess(result, url) {
            this.tasks = result.data;
            this.next = result.meta.dates.next || null;
            this.previous = result.meta.dates.previous || null;
            this.otherTaskDates = result.meta.dates.all || null;
            this.updateSelectedTaskIndex();
        },
        tasksGetFailure(e, url) {
            console.log(e);
            console.log(url);
        }
    }
}

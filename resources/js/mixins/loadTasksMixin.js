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
        getTasksForDate({date}) {
            this.selectedTaskIndex = null;
            this.date = date;
            const placeholders = { '__date__' : date };
            NetworkClient.request(api.v1.get.tasks, null, placeholders, null, this.dateTasksGetSuccess, this.tasksGetFailure);
        },
        dateTasksGetSuccess(result, url) {
            this.tasks = result.data;
            this.next = result.meta.dates.next || null;
            this.previous = result.meta.dates.previous || null;
            this.otherTaskDates = result.meta.dates.all || null;
        },
        getTasksForTag({id}) {
            const placeholders = { '__tagid__' : id };
            NetworkClient.request(api.v1.get.tagTasks, null, placeholders, null, this.tagTasksGetSuccess, this.tasksGetFailure);
        },
        tagTasksGetSuccess(result, url) {
            this.tasks = result.data;
            console.log('get taskTagsSuccess '+url);
            console.log(result);
            this.showTasks = true;
        },
        tasksGetFailure(e, url) {
            console.log(e);
            console.log(url);
        }
    }
}

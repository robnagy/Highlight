export default {
    computed: {
        today() {
            let d = new Date;
            return this.formatDate(d);
        },
    },
    methods: {
        changeDate(dateObject) {
            this.showDatePicker = false;
            this.date = this.formatDate(dateObject);
        },
        dateStringToObject(date) {
            let dateParts = date.split('-');
            let d = new Date(dateParts[0], dateParts[1] -1, dateParts[2]);
            let dArray = date.split('-');
                d.setFullYear = dArray[0];
                d.setMonth = dArray[1] -1;
                d.setDate = dArray[2];
            return d;
        },
        dateTimeStringToDate(dateTime) {
            let date = dateTime.split(' ')[0];
            return this.dateStringToObject(date);
        },
        formatDate(d) {
            return d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate();
        },
        setDate(date) {
            this.date = date;
        },
    }
}

import {TASK_STATUS} from '../config/tasks';

export default {
    methods: {
        selectATask(taskIndex, tasks, onChange) {
            let taskAlreadySelected = tasks[taskIndex].status === TASK_STATUS.selected;
            // iterate through all tasks and deselect them
            this.mixinDeselectAllTasks(tasks, onChange);

            if (!taskAlreadySelected) {
                if (tasks[taskIndex].status !== TASK_STATUS.completed) {
                    tasks[taskIndex].status = TASK_STATUS.selected;
                    if (onChange) onChange(tasks[taskIndex], taskIndex);
                }
            }
        },
        mixinDeselectAllTasks(tasks, onChange) {
            tasks.forEach(function(task, index){
                if (task.status === TASK_STATUS.selected) {
                    task.status = TASK_STATUS.new;
                    if (onChange) onChange(task, index);
                }
            });
        }
    }
}

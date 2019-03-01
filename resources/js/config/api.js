const baseUrl = `${process.env.MIX_APP_URL}`;

export default {
    v1: {
        get: {
            subtasks: {
                url: `${baseUrl}/user/__userid__/task/__taskid__/subtasks`,
                method: 'GET'
            },
            tags: {
                url: `${baseUrl}/user/__userid__/tags`,
                method: 'GET'
            },
            tasks: {
                url: `${baseUrl}/user/__userid__/tasks`,
                method: 'GET'
            },
        },
        patch: {
            subtask: {
                url: `${baseUrl}/user/__userid__/task/__taskid__/subtask/__subtaskid__`,
                method: 'PATCH'
            },
            task: {
                url: `${baseUrl}/user/__userid__/task/__id__`,
                method: 'PATCH'
            },
        },
        post: {
            subtask: {
                url: `${baseUrl}/user/__userid__/task/__taskid__/subtask`,
                method: 'POST'
            },
            tag: {
                url: `${baseUrl}/user/__userid__/task`,
                method: 'POST'
            },
            task: {
                url: `${baseUrl}/user/__userid__/task`,
                method: 'POST'
            },
        },
        delete: {
            subtask: {
                url: `${baseUrl}/user/__userid__/task/__taskid__/subtask/__subtaskid__`,
                method: 'DELETE'
            },
            task: {
                url: `${baseUrl}/user/__userid__/task/__taskid__`,
                method: 'DELETE'
            }
        }
    }
}

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
            tagTask: {
                url: `${baseUrl}/user/__userid__/task/__taskid__/tags`,
                method: 'GET'
            },
            tagTaskLink: {
                url: `${baseUrl}/user/__userid__/task/__taskid__/tag/__tagid__/link`,
                method: 'GET'
            },
            tagTaskUnlink: {
                url: `${baseUrl}/user/__userid__/task/__taskid__/tag/__tagid__/unlink`,
                method: 'GET'
            },
            tasks: {
                url: `${baseUrl}/user/__userid__/tasks/__date__`,
                method: 'GET'
            },
        },
        patch: {
            subtask: {
                url: `${baseUrl}/user/__userid__/task/__taskid__/subtask/__subtaskid__`,
                method: 'PATCH'
            },
            tag: {
                url: `${baseUrl}/user/__userid__/tag/__tagid__`,
                method: 'PATCH'
            },
            task: {
                url: `${baseUrl}/user/__userid__/task/__taskid__`,
                method: 'PATCH'
            },
        },
        post: {
            subtask: {
                url: `${baseUrl}/user/__userid__/task/__taskid__/subtask`,
                method: 'POST'
            },
            tag: {
                url: `${baseUrl}/user/__userid__/tag`,
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

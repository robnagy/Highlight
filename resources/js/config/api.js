const baseUrl = `${process.env.MIX_APP_URL}`;

export default {
    v1: {
        get: {
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
            task: {
                url: `${baseUrl}/user/__userid__/task/__id__`,
                method: 'PATCH'
            },
        },
        post: {
            task: {
                url: `${baseUrl}/user/__userid__/task`,
                method: 'POST'
            },
            tag: {
                url: `${baseUrl}/user/__userid__/task`,
                method: 'POST'
            },
		}
    }
}

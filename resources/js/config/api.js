const baseUrl = `${process.env.MIX_APP_URL}/api`;

export default {
    v1: {
        get: {
            tags: {
                url: `${baseUrl}/user/__userid__/tags`,
                method: 'GET'
            },
        },
        post: {
            tag: {
                url: `${baseUrl}/user/__userid__/tag`,
                method: 'POST'
            }
		}
    }
}

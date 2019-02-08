const baseUrl = process.env.MIX_APP_URL;

export default {
  v1: {
    get: {
      tags: {
        url: `${baseUrl}/tags/`,
        mutations: {
          success: 'SET_TAGS_SUCCESS',
          error: 'SET_TAGS_ERROR',
        },
        method: 'GET'
      },
    },
    post: {
			tag: `${baseUrl}/tag/`,
			mutations: {
				success: 'SET_TAG_SUCCESS',
				error: 'SET_TAG_ERROR',
			},
		}
  }
}

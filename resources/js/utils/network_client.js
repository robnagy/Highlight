import Http from 'axios';
import EventBus from '../events/event-bus';
import store from '../store';

const NetworkClient = {
  idOrNil: id => (id === undefined || id === null ? '' : id),

  injectUserId: (url, userId) => (userId === undefined || userId === null ? url : url.replace("__userid__", userId)),

  request: (commit, { url, mutations, method, setAuthHeaders }, data, userId, id, params) => {
    Http.request({
      method,
      url: `${NetworkClient.injectUserId(url, userId)}${NetworkClient.idOrNil(id)}`,
      data,
      params,
      responseType: 'json',
      headers: {
        Authorization: NetworkClient.authHeaders(setAuthHeaders),
        'Content-Type': 'application/json',
      },
    })
      .then((response) => {
        commit(mutations.success, response.data);
      })
      .catch((e) => {
        commit('SET_API_ERRORS', e.response);
        commit(mutations.error, e.response);
        EventBus.$emit('errorFlashMessage', 'There are errors with your request');
        if (['staging', 'production'].includes(process.env.NODE_ENV)) {
          Raven.captureException(e);
        }
      });
  },

  authHeaders: (setAuthHeaders) => {
    if (setAuthHeaders) {
      const currentToken = store.getters.GET_CSRF_TOKEN();
      return `X-CSRF-TOKEN: ${currentToken}`;
    }
    return '';
  },

  logoutUser: () => {
    store.dispatch('LOGOUT');
  },
};

export default NetworkClient;

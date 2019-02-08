import Http from 'axios';
import EventBus from '../events/event-bus';
import store from '../store';

const NetworkClient = {
  idOrNil: id => (id === undefined || id === null ? '' : id),

  request: (commit, { url, mutations, method, setAuthHeaders }, data, id, params) => {
    Http.request({
      method,
      url: `${url}${NetworkClient.idOrNil(id)}`,
      data,
      params,
      responseType: 'json',
      headers: {
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


  logoutUser: () => {
    store.dispatch('LOGOUT');
  },
};

export default NetworkClient;

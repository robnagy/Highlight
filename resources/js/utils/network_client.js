import Http from 'axios';
import EventBus from '../events/event-bus';

const NetworkClient = {
  idOrNil: id => (id === undefined || id === null ? '' : id),

  getUserId: () => document.querySelector('meta[name="highlight-user-id"]').getAttribute('content') || undefined,

  injectUserId: (url) => (NetworkClient.getUserId() === undefined ? url : url.replace("__userid__", NetworkClient.getUserId())),

  request: ({ url, method, setAuthHeaders }, data, id, params, onSuccess, onError) => {
    Http.request({
      method,
      url: `${NetworkClient.injectUserId(url)}${NetworkClient.idOrNil(id)}`,
      data,
      params,
      responseType: 'json',
      headers: {
        Authorization: NetworkClient.authHeaders(setAuthHeaders),
        'Content-Type': 'application/json',
      },
    })
      .then((response) => {
        onSuccess(response.data, `${NetworkClient.injectUserId(url)}${NetworkClient.idOrNil(id)}`);
      })
      .catch((e) => {
        onError(e, `${NetworkClient.injectUserId(url)}${NetworkClient.idOrNil(id)}`)
        EventBus.$emit('errorFlashMessage', 'There are errors with your request');
      });
  },

  authHeaders: (setAuthHeaders) => {
    if (setAuthHeaders) {
      let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      return `X-CSRF-TOKEN: ${csrf}`;
    }
    return '';
  },
};

export default NetworkClient;

import Http from 'axios';
import EventBus from '../events/event-bus';

const NetworkClient = {

  replacePlaceholders(url, holders) {
    holders = holders || {};
    holders['__userid__'] = NetworkClient.getUserId()
    Object.keys(holders).forEach(p => url = url.replace(p, holders[p]));
    return url;
  },

  getUserId: () => document.querySelector('meta[name="highlight-user-id"]').getAttribute('content') || undefined,


  request: ({ url, method, setAuthHeaders }, data, placeholders, params, onSuccess, onError) => {
    Http.request({
      method,
      url: `${NetworkClient.replacePlaceholders(url, placeholders)}`,
      data,
      params,
      responseType: 'json',
      headers: {
        Authorization: NetworkClient.authHeaders(setAuthHeaders),
        'Content-Type': 'application/json',
      },
    })
      .then((response) => {
        onSuccess(response.data, `${NetworkClient.replacePlaceholders(url, placeholders)}`);
      })
      .catch((e) => {
        onError(e, `${NetworkClient.replacePlaceholders(url, placeholders)}`)
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

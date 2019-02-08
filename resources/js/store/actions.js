import NetworkClient from '../utils/network_client';
import api from '../config/api';

/* =========================================================
  GET REQUESTS
========================================================= */

function GET_TAGS_FOR_USER({ commit }, { params }) {
  NetworkClient.request(commit, api.v1.get.tags, {}, null, params);
}

// function GET_RECIPIENT({ commit }, { id }) {
//   NetworkClient.request(commit, api.v1.get.recipient, {}, id);
// }

/* =========================================================
  PUT REQUESTS
========================================================= */

function UPDATE_USER_TAGS({ commit }, { data, id }) {
  NetworkClient.request(commit, api.v1.put.updateProfile, data, id);
}


/* =========================================================
  POST REQUESTS
========================================================= */

// function LOGIN({ commit }, data) {
//   NetworkClient.request(commit, api.v1.post.login, data);
// }

/* =========================================================
  DELETE REQUESTS
========================================================= */

// function DELETE_USER({ commit }, { id }) {
//   NetworkClient.request(commit, api.v1.delete.user, {}, id);
// }

/* =========================================================
  STRAIGHT MUTATIONS
========================================================= */
// function CLEAR_2FA_ERRORS({ commit }) {
//   commit('CLEAR_2FA_ERRORS');
// }

// function SET_FINGERPRINT({ commit }, data) {
//   commit('SET_FINGERPRINT', data);
// }


export default {
  GET_TAGS_FOR_USER,
  UPDATE_USER_TAGS,
};

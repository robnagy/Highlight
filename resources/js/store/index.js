import Vuex from 'Vuex';
import Vue from 'Vue';
// import createPersistedState from 'vuex-persistedstate';

import state from './state';
import getters from './getters';
import mutations from './mutations';
import actions from './actions';

Vue.use(Vuex);

export default new Vuex.Store({
  state,
  plugins: [],
  getters,
  mutations,
  actions,
});

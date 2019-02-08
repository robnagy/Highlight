import EventBus from '../events/event-bus';
import defaultState from './state';

function SET_API_ERRORS(state, payload) {
    state.api.errors = payload;
}

function SET_TAGS_SUCCESS(state, payload) {
  state.tags = payload.data || [];
  EventBus.$emit('SET_TAGS_SUCCESS');
}

function SET_TAGS_ERROR(state, payload) {
  state.tagsError = payload;
  EventBus.$emit('SET_TAGS_ERROR');
}

export default {
  SET_API_ERRORS,
  SET_TAGS_SUCCESS,
  SET_TAGS_ERROR,
};

import {createApp} from 'vue';
import Vuex from 'vuex';

const app = createApp();
app.use(Vuex);

export default new Vuex.Store({
  state: {
    isLoggedIn: false,
  },
  mutations: {
    setLoggedIn(state, value) {
      state.isLoggedIn = value;
    },
  },
});
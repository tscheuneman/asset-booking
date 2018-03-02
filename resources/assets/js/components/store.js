import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        count: 0
    },
    getters: {
        countGet: state => state.count,
    },
    mutations: {
        change (state, value) {
            // mutate state
            state.count = value;
        },
        increment (state) {
            // mutate state
            state.count++;
        },
    }
});
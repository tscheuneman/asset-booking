import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        bookingEvents: [],
        assets: [],
        regions: [],
        count: 0,
        username: '',
        first_name: '',
        last_name: '',
    },
    getters: {
        countGet: state => state.count,
        getFirstName: state => state.first_name,
        getCartItems: state => {
            return state.bookingEvents;
        }
    },
    mutations: {
        change (state, value) {
            // mutate state
            state.count = value;
        },
        changeFirstName (state, value) {
            state.first_name = value;
        },
        addBookingEvent (state, value) {
            state.bookingEvents = value;
        },
        addAssets (state, value) {
            state.assets = value;
        },
        addRegions (state, value) {
            state.regions = value;
        },
        increment (state) {
            // mutate state
            state.count++;
        },
        addToCart (state, value) {
            state.bookingEvents.push(value);
        }
    }
});
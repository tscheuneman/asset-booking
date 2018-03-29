import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        bookingEvents: [],
        assets: [],
        regions: [],
        categories: [],
        user: [],
        count: 0,
    },
    getters: {
        countGet: state => state.count,
        getCartItems: state => {
            return state.bookingEvents;
        }
    },
    mutations: {
        change (state, value) {
            // mutate state
            state.count = value;
        },
        deleteEntry (state, value) {
            // mutate state
            let cnt = 0;
            state.bookingEvents.forEach(function(entry) {
                if(value === entry.booking.id) {
                    state.bookingEvents.splice(cnt, 1);
                }
                cnt++;
            });
        },
        changeUser (state, value) {
            state.user = value;
        },
        addBookingEvent (state, value) {
            state.bookingEvents = value;
        },
        addAssets (state, value) {
            state.assets = value;
        },
        addCategories (state, value) {
            state.categories = value;
        },
        addRegions (state, value) {
            state.regions = value;
        },
        increment (state) {
            // mutate state
            state.count++;
        },
        lowerEntry (state) {
            // mutate state
            state.count--;
        },
        addToCart (state, value) {
            state.bookingEvents.push(value);
        }
    }
});
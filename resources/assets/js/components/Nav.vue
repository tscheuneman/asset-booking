<template>
    <nav id="navbar" class="navbar navbar-inverse">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li v-for="element in elements"
                    :clickable="true"
                    @click="centerMap(element) + setActiveItemId(element.id)"
                    :class="{'active': activeItemId === element.id}"
                     >
                    {{ element.name }} </li>
                </ul>

                <div class="rightSide">
                    <div
                       :clickable="true"
                       @click="showCart()"
                       class="cart"
                     >
                        <i class="glyphicon glyphicon-shopping-cart"></i> Cart (<span class="items">{{ $store.state.count }}</span>)
                    </div>
                </div>
            </div><!-- /.navbar-collapse -->

        </div><!-- /.container-fluid -->

    </nav>
</template>

<script>
    import axios from 'axios';
    import { mapMutations } from 'vuex';
    import { store } from './store';

    export default {
        props: {
            user: String,
        },
        data () {
            return {
                activeItemId: '',
                elements: []
            }

        },
        mounted() {
            let self = this;
            let data = JSON.parse(this.user);
            fetch('/cart')
                .then(function(response) {
                    return response.json();
                })
                .then(function(jsonVal) {
                    let count = jsonVal.length;
                    store.commit('change', count);
                    store.commit('addBookingEvent', jsonVal);
                });

            axios.get('/api/location/regions')
                .then(function (response) {
                    let returnData = response.data;
                    store.commit('addRegions', returnData);
                    self.populateRegions(store.state.regions);
                })
                .catch(function (error) {
                    console.log(error);
                });

            store.commit('changeFirstName', data.first_name);
        },
        methods: {
            ...mapMutations([
                'change',
                'changeFirstName',
                'addBookingEvent',
                'addRegions'
            ]),
            centerMap: function(elm) {
                Vue.bus.emit('changeCenter', elm);
            },
            showCart: function() {
                $('#cart').stop().slideToggle(500);
            },
            setActiveItemId(itemIndex) {
                this.activeItemId = itemIndex
            },
            populateRegions(regions) {
                this.elements = regions;
            }
        }
    }
</script>

<style scoped>

</style>
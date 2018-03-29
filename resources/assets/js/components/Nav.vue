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
                    <li v-for="element in $store.state.regions"
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
                activeItemId: ''
            }

        },
        mounted() {
            let self = this;
            let data = this.user;

            axios.get('/cart')
                .then(function (response) {
                    let returnData = response.data;
                    let count = returnData.length;
                    store.commit('change', count);
                    store.commit('addBookingEvent', returnData);
                })
                .catch(function (error) {
                    alert("Failed to initialize cart");
                    location.reload();
                });

            axios.get('/api/location/regions')
                .then(function (response) {
                    let returnData = response.data;
                    store.commit('addRegions', returnData);
                })
                .catch(function (error) {
                    alert("Failed to initialize navigation");
                    location.reload();
                });

            axios.get('/api/user/'+data)
                .then(function (response) {
                    let returnData = response.data;
                    store.commit('changeUser', returnData);
                })
                .catch(function (error) {
                    alert("Failed to initialize user info");
                    location.reload();
                });
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
            }
        }
    }
</script>

<style scoped>

</style>
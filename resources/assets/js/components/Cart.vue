<template>
    <div id="cart">
        <div class="statusBar">

        </div>
        <div class="container">
            <div
                    :clickable="true"
                    @click="toggleCart()"
                    class="close">
                <i class="glyphicon glyphicon-remove"></i>
            </div>

            <h1>Hi {{ $store.state.user.first_name }}, you have {{$store.state.count}} items in your cart</h1>
            <entry
                    :key="i"
                    v-for="(m,i) in $store.state.bookingEvents"
                    :clickable="true"
                    @click="toggleInfoWindow(m,i)"
                    :booking="{m}"
            />
        </div>
        <button
            @click="checkoutCart()"
        >Checkout</button>
    </div>

</template>

<script>
    import { store } from './store';

    export default {
        name: "cart",
        mounted(){

        },
        methods: {
            toggleCart: function() {
                $('#cart').stop().slideToggle(500);
            },
            checkoutCart: function() {
                let returnValue = JSON.stringify(store.state.bookingEvents);
                axios.post('/api/cart/checkout', {
                    data: returnValue
                })
                 .then(function (response) {
                    if(response.data.status === "Invalid") {
                        $('.statusBar').html(response.data.message).fadeIn(500).delay(5000).fadeOut(1500);
                        let looper = response.data.data;
                        looper.forEach(function(elm) {
                            deleteFromCart(elm);
                        });
                    }
                 })
                 .catch(function (error) {
                     alert(error);
                 });

            }
        }
    }

    function deleteFromCart(id) {
        axios.post('/api/cart/entry/delete', {
            id: id
        })
            .then(function (response) {
                let res = response.data;
                if(res.status === "Success") {
                    store.commit('deleteEntry', id);
                    store.commit('lowerEntry', id);
                }
            })
            .catch(function (error) {
                alert(res.message);
            });
    }
</script>

<style scoped>
    #cart {
        background:#f4f4f4;
        position:absolute;
        width:100%;
        height:100%;
        top:0;
        left:0;
        z-index: 999;
        display:none;
        overflow-y:scroll;
    }
    div.statusBar{
        width:100%;
        height:50px;
        background:#8C1D40;
        color:#fff;
        font-size:19px;
        display:none;
        line-height:50px;
        text-align:center;
    }
    div.close {
        float:right;
        margin-top:25px;
        font-size:30px;
        color:#000;
    }
    button {
        position:absolute;
        bottom:0;
        width:100%;
        height:60px;
        background:#2ab27b;
        font-size:22px;
        font-weight:bold;
        border:none;
        color:#fff;
    }
</style>
<template>
    <div id="cart">
        <div class="container">
            <div
                    :clickable="true"
                    @click="toggleCart()"
                    class="close">
                <i class="glyphicon glyphicon-remove"></i>
            </div>

            <h1>Hi {{ $store.state.first_name }}, you have {{$store.state.count}} items in your cart</h1>
            <entry
                    :key="i"
                    v-for="(m,i) in $store.state.bookingEvents"
                    :clickable="true"
                    @click="toggleInfoWindow(m,i)"
                    :booking="{m}"
            />
        </div>
        <button>Checkout</button>
    </div>

</template>

<script>
    export default {
        name: "cart",
        mounted(){

        },
        methods: {
            toggleCart: function() {
                $('#cart').stop().slideToggle(500);
            },

        }
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
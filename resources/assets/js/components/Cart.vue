<template>
    <div id="cart">
        <div class="container">
            <div
                    :clickable="true"
                    @click="toggleCart()"
                    class="close">
                <i class="glyphicon glyphicon-remove"></i>
            </div>

            <h1>Hi {{ $store.state.first_name }}, here's your cart</h1>
            <entry
                    :key="i"
                    v-for="(m,i) in $store.state.bookingEvents"
                    :clickable="true"
                    @click="toggleInfoWindow(m,i)"
                    :booking="{m}"
            />
        </div>
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
    }
    div.close {
        float:right;
        margin-top:25px;
        font-size:30px;
        color:#000;
    }
</style>
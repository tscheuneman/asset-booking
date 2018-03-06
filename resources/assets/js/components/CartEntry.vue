<template>
    <div class="entry">
        <span class="asset">
            <strong>{{booking.asset.name}}</strong>
        </span>
    </div>
</template>

<script>
    export default {
        props: {
            booking: Object
        },
        mounted(){

        },
        name: "cart-entry"
    }
</script>

<style scoped>

</style>
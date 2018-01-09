<template>
    <div class="inputContainer">
        <label :for="name">{{labelVal}}</label>
        <input :name="name" :type="filterType" />
    </div>

</template>

<script>
    export default {
        props: {
            filterType: String,
            labelVal: String,
            name: String
        },
        data () {
            return {

            }
        },

    }
</script>

<style scoped>

</style>
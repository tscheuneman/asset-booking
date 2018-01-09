<template>
    <div id="filters">
        <indvFilter :filterType="'text'" :labelVal="'Name'" :name="'value'"></indvFilter>
    </div>
</template>

<script>
    import Filter from './Children/Filter.vue';

    export default {
        data () {
            return {

            }
        },
        components: {
            'indvFilter': Filter
        }
    }
</script>

<style scoped>

</style>
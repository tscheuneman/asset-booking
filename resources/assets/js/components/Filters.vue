<template>
    <div id="filters">
        <form v-on:submit.prevent="onSubmit">
            <label :for="'build_name'">Building: </label>
            <input
                    class="form-control"
                    :name="'build_name'"
                    :id="'build_name'"
                    :type="'text'"
                    v-model="build_name"
                    @input="searchBuilding()"
            />

            <label :for="'categories'">Categories:</label>
            <select
                    class="form-control"
                    :name="'categories'"
                    :id="'categories'"
                    v-model="cat_id"
            >
                <option value="0">All</option>
                <option
                        v-for="cat_id in categories"
                        v-bind:value="cat_id.id"
                >{{cat_id.name}}</option>
            </select>

            <label :for="'region'">Region:</label>
            <select
                    class="form-control"
                    :name="'region'"
                    :id="'region'"
                    v-model="region_id"
            >
                <option value="0">All</option>
                <option
                        v-for="region_id in region"
                        v-bind:value="region_id.id"
                >{{region_id.name}}</option>
            </select>

            <br>
            <button @click.prevent="getFormValues()">
                Submit
            </button>
        </form>
    </div>
</template>

<script>
    export default {
        props: {
            categories: Array,
            region: Array
        },
        data () {
            return {
                output: '',
                build_name: '',
                cat_id: "0",
                region_id: "0"
            }
        },
        methods: {
            onSubmit: function() {
                console.log("Test");
                /*
                Vue.bus.emit('filterMarkers', elm);
                */
            },
            getFormValues: function() {
                $.ajax({
                    method: "POST",
                    url: "/filter",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'build_name': this.build_name,
                        'cat_id': this.cat_id,
                        'region_id': this.region_id
                    }
                }).done(function( msg ) {
                    Vue.bus.emit('filterMarkers', msg);
                });

            },
            searchBuilding: function() {
                console.log('test');
            }
        }
    }
</script>

<style scoped>

</style>
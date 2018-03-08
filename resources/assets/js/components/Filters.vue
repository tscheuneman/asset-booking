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
                    v-model="cat"
            >
                <option value="0">All</option>
                <option
                        v-for="cat in $store.state.categories"
                        v-bind:value="cat.id"
                >{{cat.name}}</option>
            </select>

            <label :for="'region'">Region:</label>
            <select
                    class="form-control"
                    :name="'region'"
                    :id="'region'"
                    v-model="region"
            >
                <option value="0">All</option>
                <option
                        v-for="region in $store.state.regions"
                        v-bind:value="region.id"
                >{{region.name}}</option>
            </select>

            <br>
            <button @click.prevent="getFormValues()">
                Submit
            </button>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    import { mapMutations } from 'vuex';
    import { store } from './store';

    export default {
        data () {
            return {
                output: '',
                build_name: '',
                cat: "0",
                region: "0"
            }
        },
        mounted() {
            let self = this;

            axios.get('/api/categories')
                .then(function (response) {
                    let returnData = response.data;
                    store.commit('addCategories', returnData);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        methods: {
            ...mapMutations([
                'addCategories'
            ]),
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
                        'cat_id': this.cat,
                        'region_id': this.region
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
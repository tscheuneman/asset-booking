
<template>
    <div class="entry">
        <span class="asset">
            <span class="assetTitle">{{booking.m.booking.asset.name}}</span>
            <span><strong>Building:</strong> {{booking.m.booking.asset.location.building.name}}</span>
            <span><strong>Region:</strong> {{booking.m.booking.asset.location.region.name}}</span>
            <span><strong>From:</strong> {{booking.m.booking.time_from | dateFormat}} - <strong>To: </strong> {{booking.m.booking.time_to | dateFormat}}</span>
            <Br />
            <span><button
                    class="btn btn-danger"
                    @click="deleteEntry(booking.m.booking.id)"
            >Delete</button></span>
        </span>
    </div>
</template>

<script>
    import moment from 'moment'
    import axios from 'axios';
    import { mapMutations } from 'vuex';
    import { store } from './store';

    export default {
        props: {
            booking: Object
        },
        mounted(){

        },
        methods: {
            ...mapMutations([
                'deleteEntry',
                'lowerEntry'
            ]),
        deleteEntry: function(id) {
            alert(id);
            axios.post('/api/cart/entry/delete', {
                id: id
            })
                .then(function (response) {
                    let res = response.data;
                    if(res.status === "Success") {
                        store.commit('deleteEntry', id);
                        store.commit('lowerEntry', id);
                    }
                    console.log(res);
                })
                .catch(function (error) {
                    alert(res.message);
                });

        }
         },
        filters: {
            dateFormat: function (value) {
                if (value) {
                    return moment(String(value)).format('MMMM Do YYYY')
                }
            }
        },
        name: "cart-entry"
    }
</script>

<style scoped>
    div.entry {
        padding: 15px;
        border: 1px solid #ccc;
        margin: 18px 0;
        border-radius: 13px;
    }
    span.assetTitle {
        font-size:19px;
        font-weight:bold;
    }
    span {
        display:block;
    }
</style>
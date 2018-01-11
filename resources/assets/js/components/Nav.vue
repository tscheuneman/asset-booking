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
                    <li v-for="element in elements"
                    :clickable="true"
                    @click="centerMap(element) + setActiveItemId(element.id)"
                    :class="{'active': activeItemId === element.id}"
                     >
                    {{ element.name }} </li>
                </ul>

                <div class="rightSide">
                    <i class="glyphicon glyphicon-calendar"></i>
                    {{username}}
                </div>
            </div><!-- /.navbar-collapse -->

        </div><!-- /.container-fluid -->

    </nav>
</template>

<script>
    export default {
        props: {
            username: String,
            region: Array
        },
        data () {
            return {
                activeItemId: '',
                elements: [],
            }

        },
        mounted() {
            this.elements = this.region;
        },
        methods: {
            centerMap: function(elm) {
                Vue.bus.emit('changeCenter', elm);
            },
            setActiveItemId(itemIndex) {
                this.activeItemId = itemIndex
            }
        }
    }
</script>

<style scoped>

</style>
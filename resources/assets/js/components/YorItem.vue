<template>
    <div class="container">

        <div class="row">
            <li v-for="(item, index) in items">
               Name: {{ items[1][index].name}}
                Price:{{ items[0][index].price}}

            </li>

        </div>
    </div>
</template>

<script>


    export default {

        name: 'yor-item',
        props: ['items','value'],

        computed: {

            getItems: function () {
                this.item = this.$parent.items;
            }
           /* getItems: function () {

                this.$http.get('/lists/'+`${this.$store.state.idList}`+'/items').then(response => {

                    this.items = response.body;

                }, response => {
                    console.log('error');
                });

//                console.log('idList:: '+this.$store.state.idList);
            },*/
            /*list () {

                return `List: ${this.$store.state.idList}`
            },*/

        },

        mounted() {
//            this.getItems

        }
    }
</script>
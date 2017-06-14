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
        props: {
            items: {
                default: ()=> {
                    return [];
                }
            },

        },


        computed: {
            getItems: function () {

                this.$http.get('/lists/1/items').then(response => {
                    console.log(response.body);
                    this.items = response.body;

                }, response => {
                    console.log('error');
                });
            }
        },

        mounted() {
            this.getItems;

        }
    }
</script>
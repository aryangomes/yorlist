
<template>
    <div class="container">
        <div class="row">
            <select v-on:change="changeList" v-model="value">
                <option v-for="list in lists" :value="list.idList">
                    {{ list.created_at }}
                </option>
            </select>
            <span>Selected: {{ value }}</span>
            <li v-for="(item, index) in items">
                Name: {{ item.item.name}}
                Price:{{ item.price}}

            </li>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'yor-list',
        props: ['lists','value','items'],

        methods:{
            changeList: function(){

                this.$http.get('/lists/'+this.value+'/items').then(response => {
                    this.items = response.body;
                    console.log( this.items);
                }, response => {
                    console.log('error');
                });
            },

        },

        computed: {
            getLists: function () {

                this.$http.get('/lists').then(response => {

                    this.lists = response.body;

                }, response => {
                    console.log('error');
                });
            },

            list () {

                return `List: ${this.$store.state.idList}`
            },

        },

        mounted() {
            this.getLists;
        }

    }

</script>
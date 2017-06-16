
<template>
    <div class="container">
        <div class="row">
            <select @change="changeList" v-model="value">
                <option v-for="list in lists" :value="list.idList">
                    {{ list.created_at }}
                </option>
            </select>
            <span>Selected: {{ value }}</span>
            <li v-for="item in items">
                <yor-item v-bind:item="item"></yor-item>

            </li>
        </div>
    </div>
</template>

<script>
    import YorItem from './YorItem.vue'
    export default {
        name: 'yor-list',

        components:{
            YorItem
        },
        data:function () {
            return {
                lists:[],
                value:'',
                items:[],
                idList:''
            }
        },

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


        mounted() {
            this.$http.get('/lists').then(response => {

                this.lists = response.body;

            }, response => {
                console.log('error');
            });
        }

    }

</script>
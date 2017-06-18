
<template>
    <div class="container">
        <div class="row">
            <select  v-model="list"  :value="lista" >
                <option v-for="lista in lists" :value="lista">
                    {{ lista.created_at }}
                </option>
            </select>
            <span>Selected: {{ lista.totalPrice }}</span>


            <span v-for="item in itemsHasList">
                <yor-item v-bind:itemHasItem="item"></yor-item>

            </span>

            <button @click="saveList()">Save List</button>
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
                list:{},
                lista:{},
                itemsHasList:[],
                selected:{}
            }
        },

        methods:{


            saveList:function () {
                
                var idList = this.list.idList;
                this.$http.put('api/listhasitems',
                        {data:this.itemsHasList}

                        ).then(response => {

                    this.lista = response.body[0].get_list;
                    console.log(this.lista);

                }, response => {
                    console.log('error');
                });
            },
            getLists:function () {
                this.$http.get('api/lists').then(response => {

                    this.lists = response.body;

                }, response => {
                    console.log('error');
                });
            }


        },

        watch: {
            list:function (selected) {
                this.$http.get('api/lists/'+selected.idList+'/items').then(response => {
                    this.itemsHasList = response.body;
                    this.lista = response.body[0].get_list;

                }, response => {
                    console.log('error');
                });
            }
        },

        mounted() {
            this.getLists();
        }

    }

</script>
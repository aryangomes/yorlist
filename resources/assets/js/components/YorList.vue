<template>
    <div class="container">
        <div class="row">
            <select v-model="list" :value="lista">
                <option v-for="lista in lists" :value="lista">
                    {{ lista.created_at }}
                </option>
            </select>
            <span>Selected: {{ lista.totalPrice }}</span>


            <span v-for="(item,index) in itemsHasList">
                <yor-item v-bind:itemHasItem="item"></yor-item>  <button @click="removeItemFromList(item,index)">Remove Item From List</button>

            </span>
            <button @click="addItemInList()">Add New Item In List</button>
            <button @click="saveList()">Save List</button>
        </div>
    </div>
</template>

<script>
    import YorItem from './YorItem.vue'
    export default {
        name: 'yor-list',

        components: {
            YorItem
        },
        prop: {
            list: Object,
        },
        data: function () {
            return {
                lists: [],
                list: {},
                lista: {},
                itemsHasList: [],
                selected: {},

            }
        },

        methods: {
            addItemInList: function () {

                this.itemsHasList.push(YorItem.itemHasItem);

                this.itemsHasList[this.itemsHasList.length - 1] = Object.assign({}, this.itemsHasList[this.itemsHasList.length - 2]);

                this.itemsHasList[this.itemsHasList.length - 1].idListHasItems = null;
            },

            removeItemFromList:function (item,index) {
              console.log(item);
                console.log(index);
                this.$http.post('api/lists/removeitem',
                        {data: item}
                ).then(response => {

                    this.itemsHasList.splice(index,1);
                    console.log(index);
                    console.log(this.itemsHasList);
                }, response => {
                    console.log('error');
                });
            },

            saveList: function () {

                this.$http.put('api/listhasitems',
                        {data: this.itemsHasList}
                ).then(response => {

                    this.lista = this.list;
                    this.itemsHasList = response.body;
                    console.log(this.lista);

                }, response => {
                    console.log('error');
                });
            },
            getLists: function () {
                this.$http.get('api/lists').then(response => {

                    this.lists = response.body;

                }, response => {
                    console.log('error');
                });
            }


        },

        watch: {
            list: function (selected) {
                this.$http.get('api/lists/' + selected.idList + '/items').then(response => {

                    this.itemsHasList = response.body;

                    this.lista = selected;


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
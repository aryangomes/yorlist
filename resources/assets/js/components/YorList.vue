<template>
    <div class="container">
        <div class="row">
            <select v-model="list" :value="listModel">
                <option v-for="listModel in lists" :value="listModel">
                    {{ listModel.created_at }}
                </option>
            </select>
            <span>Price Total: {{ listModel.totalPrice }}</span>

            <button @click="createNewList()">Create New List</button>
            <button @click="deleteList()">Delete List</button>

            <span v-for="(item,index) in itemsHasList">
                <yor-item v-bind:itemHasList="item"></yor-item>  <button @click="removeItemFromList(item,index)">Remove Item From List</button>

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
                listModel: {},
                itemsHasList: [],
                selected: {},

            }
        },

        methods: {
            addItemInList: function () {

                this.itemsHasList.push(YorItem.itemHasList);

                this.itemsHasList[this.itemsHasList.length - 1] = YorItem;

                this.itemsHasList[this.itemsHasList.length - 1].idListHasItems = null;

                this.itemsHasList[this.itemsHasList.length - 1].lists_idList = this.list.idList;

                this.itemsHasList[this.itemsHasList.length - 1].price = 0;

                this.itemsHasList[this.itemsHasList.length - 1].qtd = 0;

                this.itemsHasList[this.itemsHasList.length - 1].items_idItem = 0;

                this.itemsHasList[this.itemsHasList.length - 1].isInCart = -1;

                this.itemsHasList[this.itemsHasList.length - 1].subTotal = 0;

                this.itemsHasList[this.itemsHasList.length - 1].unit = 0;
            },

            removeItemFromList: function (item, index) {

                this.$http.post('api/lists/removeitem',
                        {data: item}
                ).then(response => {

                    this.itemsHasList.splice(index, 1);

                }, response => {
                    console.log(response.body);
                });
            },

            saveList: function () {

                this.$http.put('api/listhasitems',
                        {data: this.itemsHasList}
                ).then(response => {

                    this.listModel = this.list;
                    this.itemsHasList = response.body;
                    console.log(this.listModel);

                }, response => {
                    console.log(response.body);
                });
            },

            getLists: function () {
                this.$http.get('api/lists').then(response => {

                    this.lists = response.body;

                }, response => {
                    console.log(response.body);
                });
            },

            createNewList: function () {
                this.$http.post('api/lists').then(response => {

                    this.getLists();

                }, response => {
                    console.log(response.body);
                });
            },

            deleteList: function () {
                console.log(this.listModel.idList);
                this.$http.delete('api/lists/' + this.listModel.idList).then(response => {

                    this.getLists();

                }, response => {
                    console.log(response.body);
                });
            },


        },

        watch: {
            list: function (selected) {
                this.$http.get('api/lists/' + selected.idList + '/items').then(response => {

                    this.itemsHasList = response.body;

                    this.listModel = selected;


                }, response => {
                    console.log(response.body);
                });
            }
        },

        mounted() {
            this.getLists();
        },



    }

</script>
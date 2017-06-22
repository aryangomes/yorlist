<template>
    <div class="container">

        <form @submit.prevent="saveList" class="row">
            List:
            <select @change="changeList(list)" v-model="list" :value="listModel">
                <option value="">
                    Select a list...
                </option>
                <option v-for="listModel in lists" :value="listModel">
                    {{ listModel.created_at }}
                </option>
            </select>
            <span>Price Total: {{ listModel.totalPrice }}</span>

            <button @click="createNewList()">Create New List</button>
            <button v-if="list" @click="deleteList()">Delete List</button>

            <span v-for="(item,index) in itemsHasList">
                <yor-item v-bind:itemHasList="item"></yor-item>  <button @click="removeItemFromList(item,index)">Remove Item From List</button>

            </span>
            <button v-if="list" @click.submit.prevent="addItemInList()">Add New Item In List</button>
            <input v-show="validateItem" type="submit" value="Save List"/>
        </form>

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
                list: '',
                listModel: '',
                itemsHasList: [],
                selected: {},
                validateItem: false,

            }
        },

        methods: {
            addItemInList: function () {

                this.itemsHasList.push({});

                this.itemsHasList[this.itemsHasList.length - 1] = {};

                this.itemsHasList[this.itemsHasList.length - 1].idListHasItems = null;

                this.itemsHasList[this.itemsHasList.length - 1].lists_idList = this.list.idList;

                this.itemsHasList[this.itemsHasList.length - 1].price = 0;

                this.itemsHasList[this.itemsHasList.length - 1].qtd = 1;

                this.itemsHasList[this.itemsHasList.length - 1].items_idItem = '';

                this.itemsHasList[this.itemsHasList.length - 1].isInCart = 0;

                this.itemsHasList[this.itemsHasList.length - 1].subTotal = 0;

                this.itemsHasList[this.itemsHasList.length - 1].unit = '';

                this.validateItem = false;
            },

            removeItemFromList: function (item, index) {

                this.$http.post('api/lists/removeitem',
                        {data: item}
                ).then(response => {

                    this.itemsHasList.splice(index, 1);

                }, response => {
                    console.log(response.statusText);
                });
            },

            saveList: function () {

                console.log(this.validateItem);
                if (this.validateItem) {
                    this.$http.put('api/listhasitems',
                            {data: this.itemsHasList}
                    ).then(response => {

                        this.listModel = this.list;
                        this.itemsHasList = response.body;
                        console.log(this.listModel);

                    }, response => {
                        console.log(response.statusText);
                    });
                }

            },

            getLists: function () {
                this.$http.get('api/lists').then(response => {

                    this.lists = response.body;

                }, response => {
                    console.log(response.statusText);
                });
            },

            createNewList: function () {
                this.$http.post('api/lists').then(response => {

                    this.lists.unshift(response.body);

                    this.list = this.lists[0];

                    console.log(this.listModel);


                }, response => {
                    console.log(response.statusText);
                });
            },

            deleteList: function () {
                if (this.listModel.idList != undefined) {
                    this.$http.delete('api/lists/' + this.listModel.idList).then(response => {

                        this.getLists();

                    }, response => {
                        console.log(response.statusText);
                    });
                }
            },

            changeList: function (listSelected) {
                console.log(listSelected);
                if (this.list != '') {

                    this.$http.get('api/lists/' + this.list.idList + '/items').then(response => {

                        this.itemsHasList = response.body;

                        this.listModel = this.list;

                        var totalPrice = 0;

                        this.itemsHasList.forEach(function (item) {

                            totalPrice += item.subTotal;

                        });

                        this.list.totalPrice = totalPrice;

                        this.validateItem = false;

                    }, response => {
                        console.log(response.statusText);
                    });
                } else {
                    this.listModel.totalPrice = 0;

                    this.itemsHasList = null;
                }
            }


        },

        watch: {},

        mounted() {
            this.getLists();

        },


    }

</script>
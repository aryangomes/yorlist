<template>
    <div class="container">

        <form @submit.prevent="saveList" class="row">
            List:
            <select @change="changeList(list)" v-model="list" :value="listModel">
                <option value="">
                    Select a list...
                </option>
                <option v-for="listModel in lists" :value="listModel">
                    {{ listModel.created_at  }}
                </option>
            </select>
            <span>Price Total: {{ listModel.totalPrice }}</span>

            <button @click="createNewList()">Create New List</button>

            <button v-if="list" @click="cloneList()">Clone List</button>

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
    function dateFormatted(date) {
        let dateFormatted = new Date(date);
        return  dateFormatted.getDate() + '/' + (dateFormatted.getMonth() + 1) + '/' + dateFormatted.getFullYear();
    }



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
                itemsSelecteds: [],
                itemsAux:'',

            }
        },

        methods: {
            addItemInList: function () {

                if(this.itemsHasList == null){
                    this.itemsHasList = [];
                }

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

                var aux = [];

                this.itemsHasList.forEach(function (item,index) {

                    aux.push(item.items_idItem);
                });

                this.itemsSelecteds =aux;


            },

            removeItemFromList: function (item, index) {

                this.$http.post('api/lists/removeitem',
                        item
                ).then(response => {

                    this.itemsHasList.splice(index, 1);

                }, response => {
                    console.log(response.statusText);
                });
            },

            saveList: function () {

                if (this.validateItem) {
                    this.$http.put('api/listhasitems',
                            {data: this.itemsHasList}
                    ).then(response => {

                        this.listModel = this.list;

                        this.itemsHasList = response.body;

                    }, response => {
                        console.log(response.statusText);
                    });
                }

            },

            getLists: function () {
                this.$http.get('api/lists').then(response => {

                    this.lists = response.body;

                    this.lists.forEach(function (item,index) {
                        item.created_at =dateFormatted(item.created_at);
                    });

                }, response => {
                    console.log(response.statusText);
                });
            },

            createNewList: function () {
                this.$http.post('api/lists').then(response => {

                    this.lists.unshift(response.body);

                    this.list = this.lists[0];

                    this.changeList(this.list);

                    this.list.created_at = dateFormatted(this.list.created_at);

                }, response => {
                    console.log(response.statusText);
                });
            },

            deleteList: function () {
                if (this.listModel.idList != undefined) {

                    this.$http.delete('api/lists/' + this.listModel.idList).then(response => {

                        this.getLists();

                        this.list ="";

                        this.changeList("");

                        this.validateItem =false;

                    }, response => {
                        console.log(response.statusText);
                    });
                }
            },

            changeList: function (listSelected) {

                if (this.list != '' && this.list != "") {

                    this.$http.get('api/lists/' + this.list.idList + '/items').then(response => {

                        this.itemsHasList = response.body;

                        this.listModel = this.list;

                        var totalPrice = 0;

                        if(this.itemsHasList.length > 0){
                            this.itemsHasList.forEach(function (item) {

                                totalPrice += item.subTotal;

                            });

                            this.validateItem = false;
                        }else{
                            this.addItemInList();
                        }

                        var aux = [];

                        this.itemsHasList.forEach(function (item,index) {
                            aux.push(item.items_idItem);
                        });

                        this.itemsSelecteds =aux;

                        console.log('this.itemsSelecteds: '+this.itemsSelecteds);


                        this.list.totalPrice = totalPrice;





                    }, response => {
                        console.log(response.statusText);
                    });
                } else {
                    this.listModel.totalPrice = 0;

                    this.itemsHasList = null;
                }
            },

            cloneList:function () {
                console.log(this.list);

                this.$http.post('api/lists/clonelist',
                       this.list).then(response => {

                    console.log(response.body);

                    this.lists.unshift(response.body);

                    this.list = this.lists[0];

                    this.changeList(this.list);

                    this.list.created_at = dateFormatted(this.list.created_at);



                }, response => {
                    console.log(response.statusText);
                });
            }


        },

        watch: {},

        mounted() {
            this.getLists();



        },

    }

</script>
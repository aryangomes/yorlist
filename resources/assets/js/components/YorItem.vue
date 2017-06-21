<template>

    <li class="container">
        <select v-model="itemHasList.items_idItem">
            <option value="0" >
                Select a item
            </option>
            <option v-for="item in items" :value="item.idItem">
                {{ item.name}}
            </option>
        </select>

        qtd: <input @keyup="updateSubTotal()" type="number" id="qtd" name="qtd" v-model="itemHasList.qtd"/>

        Price: <input @keyup="updateSubTotal()" type="number" id="price" name="price" v-model="itemHasList.price"/>

        <input type="hidden" id="lists_idList" name="lists_idList" v-model="itemHasList.lists_idList"/>

        isInCart: <select v-model="itemHasList.isInCart">

        <option value="-1">
            Select if item has in cart
        </option>
        <option :value="0">
            Não
        </option>
        <option :value="1">
            Sim
        </option>
    </select>

        subTotal: <span id="subTotal" name="subTotal">
            {{itemHasList.subTotal}}
        </span>

        Unit: <select v-model="itemHasList.unit">
        <option value="0" >
            Select the unit
        </option>
        <option value="unid">
            Uni.
        </option>
        <option value="l">
            L
        </option>
    </select>

    </li>
</template>

<script>


    export default {

        name: 'yor-item',
        props: {
            itemHasList: {
                type: Object,
                default: function () {
                    return {
                        price:0,
                        lists_idList:0,
                        items_idItem:0,
                        isInCart:0,
                        subTotal:0,
                        qtd:1,
                        unit:'unid',
                        idListHasItems:0,
                    }
                },
                required:true
            }
        },
        data: function () {
            return {
                items: [],
                list: {},


            }
        },
        methods: {
            updateSubTotal: function () {

                this.itemHasList.subTotal = this.itemHasList.price * this.itemHasList.qtd;

                var totalPrice = 0;

                this.$parent.itemsHasList.forEach(function (item) {

                    totalPrice += item.subTotal;

                });

                this.$parent.list.totalPrice = totalPrice;

            }

        },

        mounted() {
            this.$http.get('api/items').then(response => {

                this.items = response.body;

            }, response => {
                console.log('error');
            });
        }


    }
</script>
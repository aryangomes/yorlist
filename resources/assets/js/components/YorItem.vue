<template>

    <li class="container">
       Item:
        <select @change="validateItem()"   v-model="itemHasList.items_idItem" v-validate="'required'" data-vv-name="itemHasList.items_idItem" data-vv-value-path="itemHasList.items_idItem">
             <option value="">
                Select a item
            </option>
            <option v-for="item in items" :value="item.idItem">
                {{ item.name}}
            </option>
        </select>

        <span v-show="errors.has('itemHasList.items_idItem')">{{ errors.first('itemHasList.items_idItem') }}</span>

        qtd: <input v-validate="'required|min_value:1'"   @keyup="validateItem(),updateSubTotal()" type="number" id="qtd"
                    name="itemHasList.qtd" v-model="itemHasList.qtd"/>

        <span v-show="errors.has('itemHasList.qtd')">{{ errors.first('itemHasList.qtd') }}</span>

        Price: <input v-validate="'required|min_value:1'" @keyup="validateItem(),updateSubTotal()" type="number" id="price" name="itemHasList.price"
                      v-model="itemHasList.price"/>


        <span v-show="errors.has('itemHasList.price')">{{ errors.first('itemHasList.price') }}</span>
        <input  type="hidden" id="lists_idList" name="lists_idList" v-model="itemHasList.lists_idList"/>

        isInCart: <select @change="validateItem()" v-validate="'required'" data-vv-name="itemHasList.isInCart" data-vv-value-path="itemHasList.isInCart"  v-model="itemHasList.isInCart">



        <option value="">
            Select if item has in cart
        </option>
        <option :value="0">
            Não
        </option>
        <option :value="1">
            Sim
        </option>
    </select>
        <span v-show="errors.has('itemHasList.isInCart')">{{ errors.first('itemHasList.isInCart') }}</span>

        subTotal: <span id="subTotal" name="subTotal">
            {{itemHasList.subTotal}}
        </span>

        Unit:
        <select @change="validateItem()" v-model="itemHasList.unit"  v-validate="'required'"  data-vv-name="itemHasList.unit"  data-vv-value-path="itemHasList.unit" >
            <option value="">
                Select the unit
            </option>
            <option value="unid">
                Uni.
            </option>
            <option value="l">
                L
            </option>
        </select>

        <span v-show="errors.has('itemHasList.unit')">{{ errors.first('itemHasList.unit') }}</span>

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
                        price: 0,
                        lists_idList: 0,
                        items_idItem: 0,
                        isInCart: 0,
                        subTotal: 0,
                        qtd: 1,
                        unit: 'unid',
                        idListHasItems: 0,
                    }
                },
                required: true
            }
        },
        data: function () {
            return {
                items: [],
                list: {},
                qtd: 0,


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


            },
            validateItem: function () {


                this.$validator.validateAll().then(() => {

                    this.$parent.validateItem = true;
                    console.log('true');
                }).catch(() => {
                    this.$parent.validateItem = false;
                    console.log('false');
                });


            }

        },

        mounted() {
            this.$http.get('api/items').then(response => {

                this.items = response.body;

            }, response => {
                console.log('error');
            });
        },


    }
</script>
<template>

    <li class="container">
        <select v-model="itemHasItem.items_idItem">
            <option v-for="item in items" :value="item.idItem">
                {{ item.name}}
            </option>
        </select>

        qtd: <input type="number" id="qtd" name="qtd" v-model="itemHasItem.qtd"/>

        Price: <input type="number" id="price" name="price" v-model="itemHasItem.price"/>

        <input type="hidden" id="lists_idList" name="lists_idList" v-model="itemHasItem.lists_idList"/>

        isInCart: <select v-model="itemHasItem.isInCart">

        <option :value="0">
            Não
        </option>
        <option :value="1">
            Sim
        </option>
    </select>

        subTotal: <input type="text" id="subTotal" name="subTotal" v-model="itemHasItem.subTotal"/>

        Unit: <select v-model="itemHasItem.unit">
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
            itemHasItem: {
                type:Object,
                default: function () {
                    return {
                        price:0,
                        lists_idList:0
                    }
                }
            }
        },
        data: function () {
            return {
                items: [],
                list: {}

            }
        },
        methods: {},

        mounted() {
            console.log(this.list);
            this.$http.get('api/items').then(response => {

                this.items = response.body;

            }, response => {
                console.log('error');
            });
        }


    }
</script>
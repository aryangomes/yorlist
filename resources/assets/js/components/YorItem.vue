<template>

<li>
   <select name="items_idItem[]" v-model="itemHasItem.items_idItem" >
      <option v-for="item in items" :value="item.idItem">
         {{ item.name}}
      </option>
   </select>
   <!--Name:<input type="text" id="name" name="name" v-model="itemHasItem.item.name" />-->
   Price: <input type="text" id="price" name="price" v-model="itemHasItem.price" />

   <!--<button @click="addItemInList()">+</button>-->
</li>
</template>

<script>


    export default {

        name: 'yor-item',
        props: {
            itemHasItem:Object,
        },
       data:function () {
        return {
           items:[],
        }
       },
       methods:{
          addItemInList: function () {

          }
       },

       mounted() {
          this.$http.get('api/items').then(response => {

             this.items = response.body;

          }, response => {
             console.log('error');
          });
       }
        /*data:function () {

            return {
                item:{},
            }
        }*/

    }
</script>
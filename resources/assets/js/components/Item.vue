<template>
    <div class="container">

        <div class="row">
            <li>
                {{ todos.totalPrice }}
            </li>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'yor-item',
        props: {
            todos: {
                default: ()=> {
                    return 0;
                }
            },

        },

        methods: {
            getItems: function () {

                this.$http.get('/lists/1').then(response => {
                    console.log(response.body);
                 this.todos = response.body;

                }, response => {
                    console.log('error');
                });
            }
        },

        computed: {
            listJson: function(){
                return JSON.parse(this.list);
            }
        },

        mounted() {
          this.getItems();

        }
    }
</script>
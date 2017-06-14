<template>
    <div class="container">
        <div class="row">
            <select v-model="value">
                <option v-for="list in lists" v-bind:value="list.idList">
                    {{ list.created_at }}
                </option>
            </select>
            <span>Selected: {{ value }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'yor-list',
        props: ['lists','value'],



        computed: {
            getLists: function () {

                this.$http.get('/lists').then(response => {
                    console.log(response.body);
                    this.lists = response.body;

                }, response => {
                    console.log('error');
                });
            }
        },

        mounted() {
            this.getLists;

        }
    }
</script>
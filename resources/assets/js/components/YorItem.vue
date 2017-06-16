<template>

            <span>
               Name: {{ item.item.name}}
                Price:{{ item.price}}

            </span>

</template>

<script>


    export default {

        name: 'yor-item',
        props: {
            item:Object,
        },
        /*data:function () {

            return {
                item:{},
            }
        }*/

    }
</script>
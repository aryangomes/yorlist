<template>

    <div>
        <button @click="mudarDados">Mudar dados do usuário

        </button>
    </div>

</template>

<script>

    export default{
        methods: {
            mudarDados(){
                const payload = {

                    name: 'Other Name',
                    email: 'other@email.com',
                    level: '2',

                };
                this.$store.commit('CHANGE_USER',payload);
            }
        }
    }
</script>
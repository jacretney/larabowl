<template>
    <Header>
        Home
    </Header>
    <MainContent>
        <div>
            <h2 class="text-lg my-4">Start a new game</h2>
            <input type="text" v-model="gameForm.name" @input="resetErrors" :class="this.error ? 'border-red-500' : ''" placeholder="Jim's birthday">
            <a
                class="py-3 px-3 my-4 mx-4 bg-indigo-500 text-white text-sm font-semibold rounded-md shadow focus:outline-none hover:bg-indigo-700 cursor-pointer"
                @click="createGame"
            >Create new game</a>
        </div>
        <div>

        </div>
        <p v-if="this.error" class="text-red-500">{{ this.error }}</p>
    </MainContent>
</template>

<script>
    import axios from 'axios';
    import Header from '../components/Header';
    import MainContent from '../components/MainContent';

    export default {
        components: {
            Header,
            MainContent,
        },

        data() {
            return {
                gameForm: {
                    name: null,
                },
                error: null,
            }
        },

        methods: {
            resetErrors() {
                this.error = null;
            },

            createGame() {
                this.error = null;

                if (! this.gameForm.name) {
                    this.error = 'Please enter a name for your game';
                    return;
                }

                axios.post('/api/game/', {
                    name: this.gameForm.name,
                }).then((response) => {
                    this.$router.push(`/game/${response.data.data.id}`);
                }).finally();
            }
        }
    }
</script>

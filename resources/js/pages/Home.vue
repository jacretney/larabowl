<template>
    <Header>
        Home
    </Header>
    <MainContent>
        <Card classes="w-1/2 m-auto">
            <template v-slot:header>
                Start a new game
            </template>
            <template v-slot:body>
                <Input
                    place-holder="Jim's birthday"
                    classes="w-full mb-3"
                    :validation-message="gameForm.name.error"
                    v-model="gameForm.name.value"
                />

                <Button text="Create new game" @click="createGame" />
            </template>
        </Card>

        <Card classes="w-1/2 m-auto">
            <template v-slot:header>
                Other games
            </template>
            <template v-slot:body>
                <LoadingSpinner
                    class="m-auto"
                    :loading="! games.loaded"
                    message="Fetching games..."
                />

                <div
                    class="columns-2 my-3"
                    v-for="game in games.inProgress"
                    :key="game.id"
                >
                    <p class="w-full">
                        {{game.name}}
                    </p>

                    <Button text="View game" classes="w-full" @click="viewGame(game)"/>
                </div>
            </template>
        </Card>
    </MainContent>
</template>

<script>
    import axios from 'axios';
    import Header from '../components/Header';
    import MainContent from '../components/MainContent';
    import Input from "../components/ui/Input";
    import Button from "../components/ui/Button";
    import Card from "../components/ui/Card";
    import LoadingSpinner from "../components/ui/LoadingSpinner";

    export default {
        components: {
            Header,
            MainContent,
            Input,
            Button,
            Card,
            LoadingSpinner,
        },

        data() {
            return {
                gameForm: {
                    name: {
                        value: null,
                        error: null,
                    },
                },
                games: {
                    loaded: false,
                    inProgress: null,
                },
            }
        },

        mounted() {
            this.fetchGames();
        },

        methods: {
            createGame() {
                if (! this.gameForm.name.value) {
                    this.gameForm.name.error = 'Please enter a name for your game';
                    return;
                }

                this.gameForm.name.error = null;

                axios.post('/api/games/', {
                    name: this.gameForm.name.value,
                }).then((response) => {
                    this.$router.push(`/game/${response.data.data.id}`);
                }).finally();
            },

            fetchGames() {
                this.games.loaded = false;

                axios.get('/api/games').then((response) => {
                    this.games.inProgress = response.data.data;
                    this.games.loaded = true;
                });
            },

            viewGame(game) {
                this.$router.push(`/game/${game.id}`);
            }
        }
    }
</script>

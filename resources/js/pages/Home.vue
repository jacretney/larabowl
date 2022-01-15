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
                    classes="w-full"
                    :validation-message="gameForm.name.error"
                    v-model="gameForm.name.value"
                />

                <Button text="Create new game" @click="createGame" />
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

    export default {
        components: {
            Header,
            MainContent,
            Input,
            Button,
            Card,
        },

        data() {
            return {
                gameForm: {
                    name: {
                        value: null,
                        error: null,
                    },
                },
            }
        },

        methods: {
            createGame() {
                if (! this.gameForm.name.value) {
                    this.gameForm.name.error = 'Please enter a name for your game';
                    return;
                }

                this.gameForm.name.error = null;

                axios.post('/api/game/', {
                    name: this.gameForm.name.value,
                }).then((response) => {
                    this.$router.push(`/game/${response.data.data.id}`);
                }).finally();
            }
        }
    }
</script>

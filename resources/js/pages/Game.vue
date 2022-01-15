<template>
    <Header>
        Game - {{ this.game ? this.game.name : 'Loading' }}
    </Header>
    <MainContent>
        <Card>
            <template v-slot:header>
                Game status: In progress
            </template>
            <template v-slot:body>
                <GameTable
                    v-if="this.game"
                    :game="this.game"
                    :current-frame="this.currentFrame"
                />
            </template>
        </Card>

        <Card
            classes="w-1/2"
            v-if="this.game"
        >
            <template v-slot:header>
                Update score
            </template>
            <template v-slot:body>
                <p>Frame: {{ this.currentFrame.frame_number }}</p>
                <p>Throw: {{ this.getThrowNumber(this.currentFrame) }}</p>
                <p>Player: Player one</p>

                <Input
                    place-holder="Enter a score"
                    classes="w-full mt-3"
                    :validation-message="scoreForm.score.error"
                    v-model="scoreForm.score.value"
                />

                <Button text="Submit score" @click="submitScore" />
            </template>
        </Card>
    </MainContent>
</template>

<script>
import Header from '../components/Header';
import MainContent from '../components/MainContent';
import Input from "../components/ui/Input";
import Button from '../components/ui/Button';
import Card from "../components/ui/Card";
import GameTable from "../components/tables/GameTable";

export default {
    components: {
        Header,
        MainContent,
        Input,
        Button,
        Card,
        GameTable,
    },

    data() {
        return {
            gameId: this.$route.params.game,
            game: null,
            scoreForm: {
                score: {
                    value: null,
                    error: null,
                },
            }
        }
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            axios.get(`/api/game/${this.gameId}`)
                .then((response) => {
                    this.game = response.data.data;
                });
        },

        submitScore() {
            axios.post(`/api/game/${this.gameId}/frame/${this.currentFrame.id}`, {
                'throw': this.getThrowNumber(this.currentFrame),
                'score': this.scoreForm.score.value,
            })
            .then((response) => {
                this.game.frames = response.data.data.frames;
            })
        },

        getThrowNumber(frame) {
            if (frame.throw_one_score === null) {
                return 1;
            }

            if (frame.throw_two_score === null) {
                return 2;
            }

            return 3;
        }
    },

    computed: {
        currentFrame() {
            const incompleteFrames = this.game.frames.filter((frame) => {
                // Throw one wasn't a strike (or is null) and throw two is null
                return frame.throw_one_score !== 10 && frame.throw_two_score === null;
            });

            return incompleteFrames[0];
        },
    }
}
</script>

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
    </MainContent>
</template>

<script>
import Header from '../components/Header';
import MainContent from '../components/MainContent';
import Card from "../components/ui/Card";
import GameTable from "../components/tables/GameTable";

export default {
    components: {
        Header,
        MainContent,
        Card,
        GameTable,
    },

    data() {
        return {
            gameId: this.$route.params.game,
            game: null,
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
    },

    computed: {
        currentFrame() {
            const incompleteFrames = this.game.frames.filter((frame) => {
                // Throw one wasn't a strike (or is null) and throw two is null
                return frame.throw_one_score !== 10 && frame.throw_two_score === null;
            });

            return incompleteFrames[0];
        }
    }
}
</script>

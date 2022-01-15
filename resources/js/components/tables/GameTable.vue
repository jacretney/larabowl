<template>
    <!-- TODO: Add a foreach for players -->
    <table v-if="this.game" class="table-fixed w-full text-center">
        <thead>
        <tr>
            <th class="w-1/6">
                Player
            </th>
            <th
                v-for="frame in this.game.frames"
                :class="isCurrentFrame(frame) ? 'bg-green-300' : null"
            >
                {{ frame.frame_number }}
            </th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td class="w-1/6">
                Player one
            </td>
            <td
                v-for="frame in this.game.frames"
                :class="isCurrentFrame(frame) ? 'bg-green-300' : null"
            >
                <div v-if="frame.frame_number !== 10" class="grid grid-cols-2 grid-rows-1">
                    <p>{{ frame.throw_one_score ?? '-' }}</p>
                    <p>{{ frame.throw_two_score ?? '-' }}</p>
                </div>

                <div v-else class="grid grid-cols-3 grid-rows-1">
                    <p>{{ frame.throw_one_score ?? '-' }}</p>
                    <p>{{ frame.throw_two_score ?? '-' }}</p>
                    <p>{{ frame.throw_three_score ?? '-' }}</p>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        game: {
            type: Object,
            required: true,
        },
        currentFrame: {
            type: Object,
            default: null,
        }
    },

    methods: {
        isCurrentFrame(frame) {
            return frame.frame_number === this.currentFrame.frame_number;
        }
    }
}
</script>

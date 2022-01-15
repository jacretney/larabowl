<template>
    <input
        type="text"
        @input="resetErrors"
        :class="{
            'border-red-500': this.validationMessage,
            [classes]: classes
        }"
        :placeholder="placeHolder"
    >

    <p v-if="this.validationMessage" class="text-red-500">{{ this.validationMessage }}</p>
</template>

<script>
export default {
    props: {
        classes: {
            type: String,
            default: null
        },
        placeHolder: {
            type: String,
            default: null,
        },
        validationMessage: {
            type: String,
            default: null
        }
    },

    methods: {
        resetErrors() {
            this.error = null;
        },
    }
}
</script>

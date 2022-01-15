<template>
    <input
        @input="handleInput"
        type="text"
        :class="{
            'border-red-500': this.validationMessage,
            'border-gray-400': !this.validationMessage,
            [classes]: classes
        }"
        class="rounded-md"
        :placeholder="placeHolder"
    >

    <p v-if="this.validationMessage" class="text-red-500">{{ this.validationMessage }}</p>
</template>

<script>
export default {
    props: {
        modelValue: {
            type: String,
            default: null,
        },
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
    emits: ['update:modelValue'],

    data () {
        return {
            content: this.modelValue
        }
    },

    methods: {
        handleInput (e) {
            this.$emit('update:modelValue', e.target.value)
        }
    }
}
</script>

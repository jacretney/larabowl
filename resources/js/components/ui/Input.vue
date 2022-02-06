<template>
    <input
        @input="handleInput"
        :type="type"
        :class="{
            'border-red-500': this.validationMessage,
            'border-gray-400': !this.validationMessage,
            [classes]: classes
        }"
        class="rounded-md"
        :placeholder="placeHolder"
        v-model="value"
        @keyup.enter="this.$emit('enter')"
    >

    <p v-if="this.validationMessage" class="text-red-500">{{ this.validationMessage }}</p>
</template>

<script>
export default {
    props: {
        modelValue: {
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
        },
        type: {
            type: String,
            default: 'text'
        }
    },
    emits: ['update:modelValue', 'enter'],

    data () {
        return {
            value: this.modelValue
        }
    },

    methods: {
        handleInput(e) {
            this.$emit('update:modelValue', e.target.value)
        },

        reset() {
            this.value = null;
        }
    }
}
</script>

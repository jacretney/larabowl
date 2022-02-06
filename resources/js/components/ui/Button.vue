<template>
    <a
        :class="{
            [classes]: classes
        }"
        class="block text-center py-3 px-3 bg-indigo-500 text-white text-sm font-semibold rounded-md shadow focus:outline-none hover:bg-indigo-700 cursor-pointer"
    >
        {{ text }}
    </a>
</template>

<script>
export default {
    props: {
        classes: {
            type: String,
            default: null,
        },
        text: {
            type: String,
            required: true,
        }
    }
}
</script>

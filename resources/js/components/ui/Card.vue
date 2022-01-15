<template>
    <div
        :class="classes"
        class="bg-white rounded-md drop-shadow-md"
    >
        <div class="mb-2 border-b-2 border-b-gray-100">
            <h2 class="text-lg py-4 mx-4">
                <slot name="header">
                    TODO: Card Header
                </slot>
            </h2>
        </div>
        <div class="py-4 mx-4">
            <slot name="body">
                TODO: Card Body
            </slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            classes: {
                type: String,
                default: null,
            }
        }
    }
</script>

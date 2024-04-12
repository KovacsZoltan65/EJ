<script setup>
    defineProps({
        type: {
            type: String,
            default: 'button',
            validator: (value) => ['button','submit','reset'].includes(value),
            required: false,
        },
        size: {
            type: String,
            default:'text-base',
            validator: (value) => ['text-xs', 'text-sm','text-base'].includes(value),
            required: false,
        },
    });
</script>

<template>
    <button type="button" 
        :class="size"
        class="focus:outline-none text-white bg-yellow-400 
            hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 
            font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 
            dark:focus:ring-yellow-900"
    >
        <slot/>
    </button>
</template>
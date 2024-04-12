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
        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none 
            focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm 
            px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 
            dark:focus:ring-gray-700 dark:border-gray-700">
        <slot/>
    </button>
</template>
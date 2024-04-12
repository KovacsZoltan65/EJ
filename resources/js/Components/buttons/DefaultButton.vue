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
    <button 
        type="button" 
        :class="size" 
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 
            focus:ring-blue-300 font-medium rounded-lg text-sm px-5 
            py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 
            focus:outline-none dark:focus:ring-blue-800">
        <slot />
    </button>
</template>
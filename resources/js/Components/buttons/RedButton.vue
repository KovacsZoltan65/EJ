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
            default:'medium',
            validator: (value) => ['small','medium', 'large'].includes(value),
            required: true
        }
    });
</script>

<template>
    <button type="button" 
        :class="size"
        class="focus:outline-none text-white 
            bg-red-700 hover:bg-red-800 
            focus:ring-4 focus:ring-red-300 
            font-medium rounded-lg 
            text-sm px-5 py-2.5 
            mr-2 mb-2 
            dark:bg-red-600 dark:hover:bg-red-700 
            dark:focus:ring-red-800">
        <slot/>
    </button>
</template>
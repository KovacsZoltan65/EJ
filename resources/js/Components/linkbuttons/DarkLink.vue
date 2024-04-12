<script setup>
    defineProps({
        type: {
            type: String,
            default: 'button',
            validator: (value) => ['button','submit','reset'].includes(value),
            required: true
        },
        href: {
            type: String,
            required: true
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
    <a :href="href" 
        type="button" 
        :class="size" 
        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none 
            focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm 
            px-5 py-2.5 mr-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 
            dark:focus:ring-gray-700 dark:border-gray-700">
        <slot/>
</a>
</template>
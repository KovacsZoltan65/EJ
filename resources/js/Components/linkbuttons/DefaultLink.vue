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
    <a :href="href" type="button" 
        :class="size" 
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 
            focus:ring-blue-300 font-medium rounded-lg text-sm px-5 
            py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 
            focus:outline-none dark:focus:ring-blue-800">
        <slot />
</a>
</template>
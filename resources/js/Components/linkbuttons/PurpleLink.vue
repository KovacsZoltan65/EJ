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
        class="focus:outline-none text-white bg-purple-700 
            hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 
            font-medium rounded-lg text-sm px-5 py-2.5 mb-2 
            dark:bg-purple-600 dark:hover:bg-purple-700 
            dark:focus:ring-purple-900">
        <slot/>
    </a>
</template>
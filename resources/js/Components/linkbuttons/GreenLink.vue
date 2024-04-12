<script setup>
    defineProps({
        type: {
            type: String,
            default: 'button',
            validator: (value) => ['button','submit','reset'].includes(value),
            required: false
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
        class="focus:outline-none text-white 
            bg-green-700 hover:bg-green-800 
            focus:ring-4 focus:ring-green-300 font-medium 
            rounded-lg text-sm 
            px-5 py-2.5 mr-2 mb-2 
            dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
        <slot/>
    </a>
</template>
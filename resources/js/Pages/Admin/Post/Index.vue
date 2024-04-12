<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';

const props = defineProps({
  posts: {
    type: Object,
    default: () => ({}),
  },
  can: {
    type: Object,
    default: () => ({}),
  },
})

</script>

<template>
    <Head title="Posztok" />

    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('posts') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex bg-gray-800 justify-between items=center p-5">
                        <div class="flex space-x-2 items-center text-white">
                            {{ $t('posts_description') }}
                        </div>
                        <div class="flex space-x-2 items-center" 
                             v-if="can.create">
                            <a href="#" class="px-4 py-2 bg-green-500 uppercase text-white rounded focus:outline-none flex items-center">
                                <span class="iconify mr-1" data-icon="gridicons:create" data-inline="false"></span>
                                + {{ $t('post') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="py-3 px-6" scope="col">{{ $t('title') }}</th>
                                <th class="py-3 px-6" scope="col">{{ $t('description') }}</th>
                                <th class="py-3 px-6" scope="col" 
                                    v-if="can.edit || can.delete">{{ $t('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" 
                                v-for="post in posts.data" :key="post.id">
                                
                                <td class="py-4 px-6" data-label="Title">
                                    {{ post.title }}
                                </td>

                                <td class="py-4 px-6" data-label="Description">
                                    {{ post.description }}
                                </td>

                                <td class="py-4 px-6 w-45" width="250px" 
                                    v-if="can.edit || can.delete">
                                    <div type="justify-start lg:justify-end" no-wrap>
                                        <button class="ml-4 bg-green-500 px-2 py-1 rounded text-white cursor-pointer" 
                                                v-if="can.edit">
                                            {{ $t('edit') }}
                                        </button>
                                        <button class="ml-4 bg-red-500 px-2 py-1 rounded text-white cursor-pointer" 
                                                v-if="can.delete">
                                            {{ $t('delete') }}
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<script setup>
    import { reactive,onMounted, watch } from 'vue';
    import axios from 'axios';
    import AppLayout from '@/Layouts/AppLayout.vue';

    import { trans } from 'laravel-vue-i18n';
    import Swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    import VPagination from '@hennge/vue3-pagination';
    import '@hennge/vue3-pagination/dist/vue3-pagination.css';

    import DefaultButton from '@/Components/buttons/DefaultButton.vue';
    import RedButton from '@/Components/buttons/RedButton.vue';
    import GreenLink from '@/Components/linkbuttons/GreenLink.vue';

    const local_storage_column_key = 'ln_permissions_grid_columns';

    const props = defineProps({
        can: {
            type: Object, default: () => ({}),
        }
    });

    const defaultFormObject = {
        name: null,
        guard_name: null
    };

    const state = reactive({
        Permissions: [],
        deletingPermissions: null,
        showSettingsModal: false,
        selected: [],
        selectAll: false,
        columns: {
            id: { label: '#', is_visible: true, is_sortable: true, is_filterable: true, },
            name: { label: 'name', is_visible: true, is_sortable: true, is_filterable: true, },
            guard_name: { label: 'guard_name', is_visible: true, is_sortable: true, is_filterable: true, },
            action: { label: 'actions', is_visible: true, is_sortable: false, is_filterable: false, },
        },
        // Oldaltörés
        pagination: {
            current_page: 1, 
            total_number_of_pages: 0, 
            per_page: 10, 
            range: 5,
        },
        // Szűrés és keresés
        filters: {
            tags: [], 
            search: null, 
            column: null, 
            direction: null,
        },
    });

    // Figyeli az oszlopok változását
    watch(state.columns, (new_value, old_value) => {
        localStorage.setItem(local_storage_column_key, JSON.stringify(new_value));
    });

    onMounted(async () => {
        
        getPermissions();

        let columns = localStorage.getItem(local_storage_column_key);

        if (columns) {
            columns = JSON.parse(columns); 
            for (const column_name in columns) { 
                state.columns[column_name] = columns[column_name]; 
            }
        }
    });

    function getPermissions(page = state.pagination.current_page) {
        
        axios.post(route('getPermissions', {
            filters: state.filters, 
            config: {
                per_page: state.pagination.per_page
            }, page
        }))
        .then(response => {
            state.Permissions = response.data.permissions.data; 
            state.pagination.total_number_of_pages = response.data.permissions.last_page; 
            state.pagination.current_page = response.data.permissions.current_page;
        });
        
    };

    // Általános alert
    const alerta = Swal.mixin({
        buttonsStyling: true
    });

    // Delete alert
    const delete_alert = Swal.mixin({
        buttonsStyling: true,
        title: trans('delete_confirmation'),
        icon: 'question',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    });

    function deleteRole_init(permission){
        
        // Figyelmeztető ablak megjelenítése
        delete_alert.fire({
            // Ablak felirata
            text: trans('permissions_delete_confirmation', {name: permission.name}),
            // "Megerősítés" gomb felirata
            confirmButtonText: trans('yes'),
            // "Elutasítás" gomb megjelenítése
            showDenyButton: false,
            // "Elutasítás" gomb felirata
            denyButtonText: trans('deny'),
            // "Mégsem" gomb megjelenítése
            showCancelButton: true,
            // "Mégsem" gomb felirata
            cancelButtonText: trans('cancel')
        }).then((result) => {
            // Választás kiértékelése
            // Feladat végrehajtható
            if( result.isConfirmed ){
                // Törlendő elem eltárolása
                state.deletingRole = permission;
                // Törlés végrehajtása
                deletePermission(permission);
            }
            // A feladat megtagadva
            else if( result.isDenied ){
                //
                alerta.fire(trans('denied'), '', 'info');
            }
            // A feladat megszakítva
            else if( result.isDismissed ){
                alerta.fire(trans('dismissed'), '', 'info');
            }
        });
    };

    // Rekord törlése
    function deletePermission(permission) {
        axios.delete(route('permissions_delete'), {permission: permission})
        .then((response) => {})
        .catch((error) => {});
    };

</script>

<template>
    <AppLayout :title="$t('permissions')">

        <!-- header -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"
            >{{ $t('permissions') }}</h2>
        </template>

        <!-- Új elem felvitelle -->
        <div class="py-6" style="padding-bottom: 0px;">
            <!-- Új elem -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">

                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                        <div class="flex justify-between items=center">
                            
                            <!-- FELIRAT -->
                            <div class="flex space-x-2 items-center">{{ $t('permissions_description') }}</div>
                            
                            <!-- GOMBOK -->
                            <div class="flex space-x-2 items-center">
                                
                                <!-- "beállítások" gomb -->
                                <DefaultButton type="button" size="text-base" 
                                    @click="settings_init">{{ $t('setup') }}</DefaultButton>
                                
                                <!--
                                    "Új permission" gomb
                                    "create" jogosultság vizsgálata
                                -->
                                <GreenLink v-if="can.create"
                                    type="button" 
                                    :href="route('permissions_create')"
                                >+ {{ $t('permissions_new') }}</GreenLink>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- Engedélyek listája -->
        <div class="py-6">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <!-- selected ids -->
                    <div class="text-uppercase text-bold mb-4 mt-4">
                        <div class="relative">id selected: {{ state.selected }}</div>
                    </div>

                    <!-- TABLE AND SEARCH -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                        <!-- SEARCH -->
                        <div class="pb-4 bg-white dark:bg-gray-900">
                            <div class="relative mt-5 ml-10 mr-10">
                                
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 
                                    pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" 
                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" 
                                        fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" 
                                            stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg> 
                                </div>

                                <!-- search field -->
                                <input type="search" id="default-search"
                                    class="block w-full p-4 pl-10 text-sm text-gray-900 border 
                                        border-gray-300 rounded-lg bg-gray-50 
                                        focus:ring-blue-500 focus:border-blue-500
                                        dark:bg-gray-700 dark:border-gray-600 
                                        dark:placeholder-gray-400 dark:text-white 
                                        dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        :placeholder="$t('subdomains_search_placeholder')" 
                                        v-model="state.filters.search" required>
                                <!-- search button --> 
                                <button type="submit"
                                    class="text-white absolute right-2.5 bottom-2.5 bg-blue-700
                                            hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                                            font-medium rounded-lg text-sm px-4 py-2
                                            dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    @click="getSubdomains()">{{ $t('search') }}</button>
                            </div>
                        </div>

                        <!-- TABLE -->
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <!-- header checkbox -->
                                <th scope="col" class="px-6 py-3">
                                    <div>
                                        <input id="checkbox-all" type="checkbox" 
                                            v-model="state.selectAll" @click="select"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500
                                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800
                                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                        <label for="checkbox-all" 
                                            class="sr-only">checkbox</label>
                                    </div>
                                </th>

                                <!-- ID -->
                                <th scope="col" class="px-6 py-3" 
                                    v-show="state.columns.id.is_visible">
                                    <div class="flex items-center">
                                        {{ state.columns.id.label }}
                                        <a href="#" v-show="state.columns.id.is_sortable">
                                            <SorterIcon />
                                        </a>
                                    </div>
                                </th>
                                
                                <!-- NAME -->
                                <th scope="col" class="px-6 py-3" 
                                    v-show="state.columns.name.is_visible">
                                    <div class="flex items-center">
                                        {{ state.columns.name.label }}
                                        <a href="#" v-show="state.columns.name.is_sortable">
                                            <SorterIcon />
                                        </a>
                                    </div>
                                </th>

                                <!-- GUARD_NAME -->
                                <th scope="col" class="px-6 py-3" 
                                    v-show="state.columns.guard_name.is_visible">
                                    <div class="flex items-center">
                                        {{ state.columns.guard_name.label }}
                                        <a href="#" v-show="state.columns.guard_name.is_sortable">
                                            <SorterIcon />
                                        </a>
                                    </div>
                                </th>

                                <!-- ACTION -->
                                <th scope="col" class="px-6 py-3" width="250px"
                                    v-show="state.columns.action.is_visible">
                                    <div class="flex items-center">
                                        {{ $t(state.columns.action.label) }}
                                        <a href="#" v-show="state.columns.action.is_sortable">
                                            <SorterIcon />
                                        </a>
                                    </div>
                                </th>

                            </thead>

                            <tbody>
                                <tr v-for="permission in state.Permissions">
                                    <!-- checkbox -->
                                    <td class="px-6 py-3 border">
                                        <div>
                                            <input :id="permission.id" 
                                                type="checkbox" 
                                                :value="permission.id"
                                                :key="permission.id" 
                                                v-model="state.selected"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500
                                                    dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800
                                                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                            <label class="sr-only" 
                                                :for="permission.id">checkbox</label>
                                        </div>
                                    </td>

                                    <!-- ID -->
                                    <td class="px-4 py-2 border" v-show="state.columns.id.is_visible">{{ permission.id }}</td>
                                    
                                    <!-- NAME -->
                                    <td class="px-4 py-2 border" v-show="state.columns.name.is_visible">{{ permission.name }}</td>

                                    <!-- GUARD_NAME -->
                                    <td class="px-4 py-2 border" v-show="state.columns.guard_name.is_visible">{{ permission.guard_name }}</td>

                                    <!-- ACTIONS -->
                                    <td class="px-4 py-2 w-45 border" width="250px" v-show="state.columns.action.is_visible">
                                        <div class="flex justify-between items=center">
                                            <!-- SZERKESZTÉS -->
                                            <green-link v-if="can.edit" 
                                                          :href="route('permissions_edit', permission.id)"
                                            >{{ $t('edit') }}</green-link>

                                            <!-- TÖRLÉS -->
                                            <red-button v-if="can.delete"
                                                        @click="deletePermission_init(permission)"
                                            >{{ $t('delete') }}</red-button>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>

                        </table>

                    </div>

                </div>
            </div>
        </div>

    </AppLayout>
</template>
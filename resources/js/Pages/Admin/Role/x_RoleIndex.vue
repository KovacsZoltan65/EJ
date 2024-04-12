<script setup>
    import {reactive, onMounted, watch, computed, ref} from 'vue';
    import axios from 'axios';

    import AppLayout from '@/Layouts/AppLayout.vue';
    import DialogModal from '@/Components/DialogModal.vue';

    import VPagination from '@hennge/vue3-pagination';
    import '@hennge/vue3-pagination/dist/vue3-pagination.css';

    import DefaultButton from '@/Components/buttons/DefaultButton.vue';
    import LightButton from '@/Components/buttons/LightButton.vue';
    import GreenButton from '@/Components/buttons/GreenButton.vue';
    import RedButton from '@/Components/buttons/RedButton.vue';

    const local_storage_column_key = 'ln_roles_grid_columns';

    const errors = ref('');

    const props = defineProps({
        can: {
            type: Object,
            default: () => ({}),
        }
    });

    const defaultFormObject = {
        title: null,
        author: null,
        image: null,
    };

    const state = reactive({
        Roles: [],
        Role: newRole(),
        editingRole: null,
        deletingRole: null,
        // Van nyitott ablak
        isFormOpen: false,
        // A folyamatban levő művelet szerkesztés
        isEdit: false,

        // "settings" modal megnyitása / bezárása
        showSettingsModal: false,
        // "edit" modal megnyitása / bezárása
        showEditModal: false,
        // "delete" modal megnyitása / bezárása
        showDeleteModal: false,

        // Kiválasztott rekordok azonosítója
        selected: [],
        // Összes elem ki van választva
        selectAll: false,
        // Táblázat oszlopai
        columns: {
            id: {
                label: '#',
                is_visible: true,
                is_sortable: true,
                is_filterable: true,
            },
            name: {
                label: 'Name',
                is_visible: true,
                is_sortable: true,
                is_filterable: true,
            },
            action: {
                label: 'Action',
                is_visible: true,
                is_sortable: false,
                is_filterable: false,
            },
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
            search: null
        },
    });

    // Figyeli az oszlopok változását
    watch(state.columns, (new_value, old_value) => {
        //console.log(new_value);
        localStorage.setItem(local_storage_column_key, JSON.stringify(new_value));
    });

    onMounted(async () => {
        getRoles();
    });

     // Szerepkörök lekérése
     function getRoles(page = state.pagination.current_page) {
        axios.post(route('getRoles', {
            filters: state.filters,
            config: {
                per_page: state.pagination.per_page,
            }, page
        })).then(response => {
            console.log(response);
            state.Roles = response.data.roles.data;
            
            state.pagination.total_number_of_pages = response.data.roles.last_page;
            state.pagination.current_page = response.data.roles.current_page;
        }).catch(error => {
            console.log(error);
        });
    };

    // Új könyv előkészítése
    function newRole_init(){
        state.Role = newRole();
        state.editingRole = null;
        state.isEdit = false;

        openEditModal();
    }

    // Új könyv adatai
    function newRole(){
        return {
            id: null,
            name: null,
        };
    }

    // Kiválasztás
    function select(){
        state.selected = [];
        if( !state.selectAll ){
            state.Roles.forEach(role => {
                state.selected.push(role.id);
            });
        }
    };

    function editRole(role){
        state.editingRole = JSON.parse(JSON.stringify(role));
        state.Role = state.editingRole;
        state.isEdit = true;

        openEditModal();
    }

    function storeRole(){
        errors.value = '';

        axios.post(route('roles_store'), state.Role)
            .then(res => {
                console.log('res', res);
                state.Books.push(res.data.role);

                closeEditModal();
            })
            .catch(e => {
                if( e.response.status == 422 ){
                    console.log(e.response.data.errors);
                    errors.value = e.response.data.errors;
                }
            });
    }

    // Szerkesztett adatok mentése
    function updateRole(){
        //
        errors.value = '';
        axios.put('roles_update', {role: state.editingRole.id})
        .then(res => {
            // 
            for(let i = 0; i < state.Roles.length; i++){
                if(state.Roles[i].id == res.data.id){
                    state.Roles[i] = res.data;
                }
            }

            closeEditModal();
        })
        .catch(e => {
            if( e.response.status == 422 ){
                console.log('e', e.response.data.errors);
                errors.value = e.response.data.errors;
            }
        });
    }

    // Törlés előkészítése
    function deleteRole_init(role){
        state.editingRole = null;
        state.deletingRole = role;

        openDeleteModal();
    }

    function deleteRole(){
        axios.delete(route('roles_delete', {role: state.deletingRole.id})).then(res => {}).catch(e => {});
    }

    // Szerkesztés megszakítása
    function cancelEdit(){
        state.editingRole = null;
        state.Role = newRole();
    }

    // Beállítások előkészítése
    function settings_init(){ openSettingsModal(); }
    
    // SETTINGS MODAL megnyitása
    function openSettingsModal() { state.showSettingsModal = true; }
    // SETTINGS MODAL bezárása
    function closeSettingsModal() { state.showSettingsModal = false; }
    // EDIT MODAL megnyitása
    function openEditModal() { state.showEditModal = true; }
    // EDIT MODAL bezárása
    function closeEditModal() {
        cancelEdit();
        state.showEditModal = false;
    }
    // DELETE MODAL megnyitása
    function openDeleteModal() { state.showDeleteModal = true; }
    // DELETE MODAL bezárása
    function closeDeleteModal() { state.showDeleteModal = false; }
</script>

<template>
    <app-layout :title="$t('roles')">

        <!-- header -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('roles') }}
            </h2>
        </template>

        <!-- Új elem felvitelle -->
        <div class="py-6" style="padding-bottom: 0px;">
            
            <!-- Új elem -->
            <div class="mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex justify-between items=center p-5">

                        <!-- FELIRAT -->
                        <div class="flex space-x-2 items-center">
                            Szerepbeállítások oldala! Itt listázhatja, létrehozhatja, frissítheti vagy törölheti a szerepkört!
                        </div>

                        <!-- new item -->
                        <div class="flex space-x-2 items-center" 
                             v-if="can.create">
                            <default-button size="text-base" @click="settings_init">Beállítások</default-button>
                            <green-button @click="newRole_init">Új szerepkör</green-button>
                            <!--<a href="#" 
                               class="px-4 py-2 bg-green-500 uppercase 
                                    text-white rounded focus:outline-none flex items-center">
                                <span class="iconify mr-1" 
                                      data-icon="gridicons:create" 
                                      data-inline="false"></span>
                                + Szerepkör
                            </a>-->
                        </div>

                    </div>
                </div>
            </div>

            <!-- Táblázat -->
            <div class="mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3" >
                                    <div>
                                        <input id="checkbox-all" 
                                            type="checkbox"
                                            v-model="state.selectAll"
                                            @click="select"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 
                                                dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 
                                                focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
                                        <label for="checkbox-all" 
                                            class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="py-3 px-6">#</th>
                                <th scope="col" class="py-3 px-6">{{ $t('name') }}</th>
                                <th scope="col" class="py-3 px-6">{{ $t('actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="role in state.Roles" 
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-3 border">
                                    <div>
                                        <input :id="role.id" type="checkbox" :value="role.id" :key="role.id" v-model="state.selected" 
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 
                                            dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 
                                            focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
                                        <label class="sr-only" :for="role.id">checkbox</label>
                                    </div>
                                </td>

                                <!-- ID -->
                                <td class="px-4 py-2 border" 
                                    v-show="state.columns.id.is_visible">{{ role.id }}</td>

                                <!-- NAME -->
                                <td class="px-4 py-2 border"
                                v-show="state.columns.name.is_visible">{{ role.name }}</td>

                                <!-- ACTIONS -->
                                <td class="px-6 py-3 border"
                                    v-show="state.columns.action.is_visible">
                                    <div type="justify-start lg:justify-end" no-wrap>
                                        <green-button class="mt-1" size="text-xs" @click="editRole(role)">{{ $t('edit') }}</green-button>
                                        <red-button class="mt-1" size="text-xs" @click="deleteRole_init(role)">{{ $t('delete') }}</red-button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </app-layout>

    <!-- EDIT MODAL -->
    <dialog-modal :show="state.showEditModal" id="edit_modal">
        <template #title></template>

        <template #content>
            <div class="grid gap-6 mb-6 md:grid-cols-2">

                <!-- hibák -->
                <div v-if="errors">
                    <div v-for="(v, k) in errors" :key="k" 
                        class="bg-red-500 text-white rounded font-bold mb-4 shadow-lg py-2 px-4 pr-0">
                        <p v-for="error in v" :key="error" class="text-sm">
                            {{ error }}
                        </p>
                    </div>
                </div>

                <!-- NÉV -->
                <div>
                    <label for="title" 
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >{{ $t('name') }}</label>
                    <input type="text" id="name" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            :placeholder="$t('name')" 
                            v-model="state.Role.name" required>
                            <span></span>
                </div>

            </div>
        </template>

        <template #footer>
            <light-button size="text-xs" type="button" @click="closeEditModal()">{{ $t('cancel') }}</light-button>
            <green-button size="text-xs" type="button" @click="storeRole()">{{ state.isEdit ? $t('update') : $t('create') }}</green-button>
        </template>
    </dialog-modal>

    <!-- SETTINGS MODAL -->
    <dialog-modal :show="state.showSettingsModal" id="settings_modal">
        <template #title></template>

        <template #content></template>

        <template #footer>
            <light-button size="text-xs" type="button" @click="closeSettingsModal()">{{ $t('cancel') }}</light-button>
        </template>
    </dialog-modal>

    <!-- CONFIRM DELETE MODAL -->
    <dialog-modal :show="state.showDeleteModal" id="delete_modal">
        <template #title>
            {{ $t('delete_role') }}
        </template>

        <template #content>
            {{ $t('roles_delete_confirmation') }}
        </template>

        <template #footer>
            <light-button size="text-xs" type="button" @click="closeDeleteModal()">{{ $t('cancel') }}</light-button>
            <red-button size="text-xs" type="button" @click="deleteRole()">{{ $t('delete') }}</red-button>
        </template>
    </dialog-modal>

</template>
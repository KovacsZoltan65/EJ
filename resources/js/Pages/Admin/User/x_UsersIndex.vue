<script setup>
    import {reactive, onMounted, watch, computed, ref} from 'vue';
    import axios from 'axios';
    
    //import { initFlowbite } from 'flowbite';

    import AppLayout from '@/Layouts/AppLayout.vue';
    //import UserForm from '../../Components/User/form.vue';
    import DialogModal from '@/Components/DialogModal.vue';

    import VPagination from '@hennge/vue3-pagination';
    import '@hennge/vue3-pagination/dist/vue3-pagination.css';

    //import SecondaryButton from '@/Components/SecondaryButton.vue';
    //import PrimaryButton from '@/Components/PrimaryButton.vue';
    import DefaultButton from '@/Components/buttons/DefaultButton.vue';
    import GreenButton from '@/Components/buttons/GreenButton.vue';
    import GreenLink from '@/Components/linkbuttons/GreenLink.vue';
    import RedButton from '@/Components/buttons/RedButton.vue';
    import LightButton from '@/Components/buttons/LightButton.vue';

    import SorterIcon from '@/Components/icons/SorterIcon.vue';

    const local_storage_column_key = 'ln_users_grid_columns';

    const errors = ref('');

    const props = defineProps({
        can: {
            type: Object,
            default: () => ({}),
        }
    });

    const defaultFormObject = {
        name: null,
        email: null,
    };

    const state = reactive({
        // Összes rekord
        Users: [],
        // Kiválasztott rekord
        User: newUser(),
        // Szerkeszteni kívánt rekord
        editingUser: null,
        // Törölni kívánt rekord
        deletingUser: null,

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
                label: 'name',
                is_visible: true,
                is_sortable: true,
                is_filterable: true,
            },
            email: {
                label: 'email',
                is_visible: true,
                is_sortable: true,
                is_filterable: true,
            },
            action: {
                label: 'actions',
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
            search: null,
            column: null,
            direction: null,
        },
    });

    // Figyeli az oszlopok változását
    watch(state.columns, (new_value, old_value) => {
        //console.log(new_value);
        localStorage.setItem(local_storage_column_key, JSON.stringify(new_value));
    });

    onMounted(async () => {
        //initFlowbite();

        getUsers();

        let columns = localStorage.getItem(local_storage_column_key);
        
        //console.log('columns', columns);

        if (columns) {
            columns = JSON.parse(columns);
            for(const column_name in columns){
                state.columns[column_name] = columns[column_name];
            }
        }
    });
    
    function sordedUser (){
        return state.Users.sort((a, b) => {
            return a.title.localeCompare(b.title);
        });
    };

    function filteredUsers (){
        return state.Users.filter((user) => {
            return user.title.toLowerCase().includes(state.filters.search.toLowerCase());
        });
    };

    // Kiválasztás
    function select(){
        state.selected = [];
        if( !state.selectAll ){
            state.Users.forEach(user => {
                state.selected.push(user.id);
            });
        }
    };

    // Táblázat adatainak lekérése
    function getUsers(page = state.pagination.current_page) {
        axios.post(route('getUsers', {
            filters: state.filters,
            config: {
                per_page: state.pagination.per_page,
            },
            page
        }))
        .then(response => {
            state.Users = response.data.users.data;
            
            state.pagination.total_number_of_pages = response.data.users.last_page;
            state.pagination.current_page = response.data.users.current_page;
        });
    }

    // Új könyv előkészítése
    function newUser_init(){
        state.User = newUser();
        state.editingUser = null;
        state.isEdit = false;

        openEditModal();
    }

    // Új könyv adatai
    function newUser(){
        return {
            id: null,
            title: null,
            author: null,
            image: null,
        };
    }

    // Szerkesztés
    function editUser(user){
        
        state.editingUser = JSON.parse(JSON.stringify(user));
        state.User = state.editingUser;
        state.isEdit = true;

        openEditModal();
    }

    // Új rekord mentése
    function storeUser(){
        errors.value = '';
        axios.post(route('users_store'), state.User)
        .then(res => {
            console.log('res', res);
            state.Users.push(res.data.user);

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
    function updateUser(){
        //
        errors.value = '';
        axios.put('users_update', {user: state.editingUser.id})
        .then(res => {
            //console.log('res', res);
            // 
            for(let i = 0; i < state.Users.length; i++){
                if(state.Users[i].id == res.data.id){
                    state.Users[i] = res.data;
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

    // Régi mentés rutin
    function saveUser(){
        
        if(state.editingUser && state.editingUser.id){
            // Rekord frissítése
            axios.put(route('users_update', {user: state.editingUser.id}), {
                title: state.editingUser.title,
                author: state.editingUser.author,
                image: state.editingUser.image,
            })
            .then((res) => {
                //
                for(let i = 0; i < state.Users.length; i++){
                    if(state.Users[i].id === res.data.id){
                        state.Users[i] = res.data;
                    }
                }

                closeEditModal();
            })
            .catch((error) => {
                console.log('updateUser', error);
            });
        }else{
            // Rekord mentése
            axios.post(route('users_store'), {
                title: state.User.title,
                author: state.User.author,
                image: state.User.image,
            })
            .then((response) => {
                //state.User = newUser();
                state.Users.push(response.data.user);

                closeEditModal();
            })
            .catch((error) => {
                console.log('storeUser', error);
            });
        }

        cancelEdit();
        return;
    }

    // Törlés előkészítése
    function deleteUser_init(user){
        state.editingUser = null;
        state.deletingUser = user;

        openDeleteModal();
    }

    // Rekord törlése
    function deleteUser(user){

        axios.delete(route('users_delete', {user: state.deletingUser.id}))
        .then((response) => {
            state.Users = state.Users.filter(user => user.id !== state.deletingUser.id);
            state.deletingUser = null;

            openDeleteModal();
        })
        .catch((error) => {
            console.log('deleteUser', error);
        });
    }

    // Szerkesztés megszakítása
    function cancelEdit(){
        state.editingUser = null;
        state.User = newUser();
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
    <app-layout :title="$t('users')">

        <!-- header -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('users') }}
            </h2>
        </template>

        <!-- Új elem felvitelle -->
        <div class="py-6" style="padding-bottom: 0px;">

            <!-- Új elem -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <div class="flex justify-between items=center">

                        <!-- FELIRAT -->
                        <div class="flex space-x-2 items-center">
                            {{ $t('users_description') }}
                        </div>

                        <!-- GOMBOK -->
                        <div class="flex space-x-2 items-center">
                            <DefaultButton></DefaultButton>
                            <GreenLink></GreenLink>
                        <!--
                            <default-button size="text-base" 
                                            @click="settings_init"
                            >{{ $t('setup') }}</default-button>
                        -->
                        <!--
                            <green-button @click="newUser_init">+ {{ $t('users_new') }}</green-button>
                        -->
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Felhasználók listája -->
        <div class="py-6">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                    <!-- selected ids -->
                    <div class="text-uppercase text-bold mb-4 mt-4">
                        <div class="relative">
                            id selected: {{state.selected}}
                        </div>
                    </div>

                    <!-- TABLE AND SEARCH -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                        <!-- SEARCH -->
                        <div class="pb-4 bg-white dark:bg-gray-900">
                            
                            <div class="relative mt-1 ml-10 mr-10">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" 
                                        aria-hidden="true" 
                                        xmlns="http://www.w3.org/2000/svg" 
                                        fill="none" 
                                        viewBox="0 0 20 20">
                                        <path stroke="currentColor" 
                                            stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            stroke-width="2" 
                                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>

                                <!-- search field -->
                                <input type="search" id="default-search" 
                                    class="block w-full p-4 pl-10 
                                        text-sm text-gray-900 border 
                                        border-gray-300 rounded-lg bg-gray-50 
                                        focus:ring-blue-500 focus:border-blue-500 
                                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    :placeholder="$t('users_search_placeholder')" 
                                    v-model="state.filters.search" 
                                    required>
                                <!-- search button -->
                                <button type="submit" 
                                    class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 
                                        hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 
                                        font-medium rounded-lg text-sm px-4 py-2 
                                        dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    @click="getUsers()"
                                >{{ $t('search') }}</button>
                            </div>
                        </div>

                        <!-- TABLE -->
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-gray-100">
                                    
                                    <!-- header checkbox -->
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
                                    <!-- ID -->
                                    <th scope="col" class="px-6 py-3" 
                                        v-show="state.columns.id.is_visible">
                                        <div class="flex items-center">
                                            {{ state.columns.id.label }}
                                            <a href="#" v-show="state.columns.id.is_sortable">
                                                <SorterIcon/>
                                            </a>
                                        </div>
                                    </th>
                                    <!-- TITLE -->
                                    <th scope="col" class="px-6 py-3" v-show="state.columns.name.is_visible">
                                        <div class="flex items-center">
                                            {{ $t(state.columns.name.label) }}
                                            <a href="#" v-show="state.columns.name.is_sortable">
                                                <SorterIcon/>
                                            </a>
                                        </div>
                                    </th>
                                    <!-- AUTHOR -->
                                    <th scope="col" class="px-6 py-3" v-show="state.columns.email.is_visible">
                                        <div class="flex items-center">
                                            {{ $t(state.columns.email.label) }}
                                            <a href="#" v-show="state.columns.email.is_sortable">
                                                <SorterIcon/>
                                            </a>
                                        </div>
                                    </th>
                                    <!-- ACTION -->
                                    <th scope="col" class="px-6 py-3" width="250px" v-show="state.columns.action.is_visible">
                                        <div class="flex items-center">
                                            {{ $t(state.columns.action.label) }}
                                            <a href="#" v-show="state.columns.action.is_sortable">
                                                <SorterIcon/>
                                            </a>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr v-for="user in state.Users">
                                    <td class="px-6 py-3 border">
                                        <div>
                                            <input :id="user.id" 
                                                   type="checkbox" 
                                                   :value="user.id" 
                                                   :key="user.id" 
                                                   v-model="state.selected" 
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                            />
                                            <label class="sr-only" :for="user.id">checkbox</label>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 border" v-show="state.columns.id.is_visible">{{ user.id }}</td>
                                    <td class="px-4 py-2 border" v-show="state.columns.name.is_visible">{{ user.name }}</td>
                                    <td class="px-4 py-2 border" v-show="state.columns.email.is_visible">{{ user.email }}</td>
                                    
                                    <td class="px-4 py-2 w-45 border" 
                                        width="250px" 
                                        v-show="state.columns.action.is_visible">
                                        <div type="justify-start lg:justify-end" 
                                             no-wrap>
                                            <green-button class="mt-1" 
                                                          size="text-xs" 
                                                          @click="editUser(user)">{{ $t('edit') }}</green-button>
                                            <red-button class="mt-1" 
                                                        size="text-xs" 
                                                        @click="deleteUser_init(user)">{{ $t('delete') }}</red-button>
                                        </div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination -->
                    <div class="mb-3 bg-white shadow bg-body rounded w-75 ln-max-width mx-auto p-3 d-flex align-items-center justify-content-center">
                        <v-pagination v-model="state.pagination.current_page" 
                            :pages="state.pagination.total_number_of_pages"  
                            :range-size="state.pagination.range"
                            active-color="#DCEDFF"
                            @update:modelValue="getUsers"/>
                    </div>

                </div>
            </div>
        </div>

    </app-layout>

    <!-- EDIT MODAL -->
    <dialog-modal :show="state.showEditModal" id="edit_modal">
        <template #title>
            <!--<span v-if="state.editingUser && state.editingUser.id">Edit User</span>
            <span v-else>Create User</span>-->
            {{ state.isEdit ? $t('users_edit') : $t('users_new') }}
        </template>

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

                <!-- TITLE -->
                <div>
                    <label for="title" 
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >{{ $t('title') }}</label>
                    <input type="text" id="title" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            :placeholder="$t('title')" 
                            v-model="state.User.title" required>
                            <span></span>
                </div>

                <!-- AUTHOR -->
                <div>
                    <label for="author" 
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >{{ $t('author') }}</label>
                    <input type="text" id="author" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 
                                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            :placeholder="$t('author')" 
                            v-model="state.User.author" required>
                </div>

                <!-- IMAGE -->
                <div>
                    <label for="image" 
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >{{ $t('image') }}</label>
                    <input type="text" id="image" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            :placeholder="$t('image')" 
                            v-model="state.User.image" required>
                </div>

            </div>
        </template>

        <template #footer>
            <light-button size="text-xs" type="button" @click="closeEditModal()"
            >{{ $t('cancel') }}</light-button>
            <green-button size="text-xs" type="button" 
                          @click="storeUser()"
            >{{ state.isEdit ? $t('users_update') : $t('users_create') }}</green-button>
        </template>

    </dialog-modal>

    <!-- CONFIRM DELETE MODAL -->
    <dialog-modal :show="state.showDeleteModal" id="delete_modal">
        <template #title>
            {{ $t('users_delete') }}
        </template>
        <template #content>
            {{ $t('users_delete_confirmation') }}
        </template>
        <template #footer>
        <!--
            <secondary-button @click="closeDeleteModal()">Cancel</secondary-button>
            <primary-button type="button" class="ml-3" @click="deleteUser()">Delete</primary-button>
        -->
            <light-button size="text-xs" type="button" @click="closeDeleteModal()">{{ $t('cancel') }}</light-button>
            <red-button size="text-xs" type="button" @click="deleteUser()">{{ $t('delete') }}</red-button>
        </template>
    </dialog-modal>

    <!-- SETTINGS MODAL -->
    <dialog-modal :show="state.showSettingsModal" id="settings_modal">
        <template #title>{{ $t('setup') }}</template>
        <template #content>
            <div v-for="(config, column) in state.columns" 
                :key="column" class="d-flex align-items-center">
                <input v-model="config.is_visible" 
                    :id="column" class="me-3" type="checkbox" />
                <label :for="column">{{ $t(config.label) }}</label>
            </div>
        </template>
        <template #footer>
            <light-button size="text-xs" type="button" 
                          @click="closeSettingsModal()">{{ $t('back') }}</light-button>
        </template>
    </dialog-modal>

</template>
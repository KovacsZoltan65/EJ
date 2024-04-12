<script setup>
    import { onMounted, reactive, watch } from 'vue';
    import axios from 'axios';
    import DefaultButton from '@/Components/buttons/DefaultButton.vue';
    import GreenLink from '@/Components/linkbuttons/GreenLink.vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import DialogModal from '@/Components/DialogModal.vue';
    
    import { trans } from 'laravel-vue-i18n';
    import Swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    const local_storage_column_key = 'ln_users_grid_columns';

    const errors = ref('');

    const props = defineProps({
        can: {
            type: Object, default: () => ({}),
        }
    });

    const defaultFormObject = {
        name: null,
        email: null,
        language: null,
        password: null,
    };

    const state = reactive({
        // Felhasználók tárolója
        Users: [],
        // Törlésre szánt felhasználó
        deletingUser: {},
        //
        showSettingsModal: false,
        // Kiválasztott rekordok azonosítója
        selected: [],
        // Összes elem ki van választva
        selectAll: false,
        //
        columns: {
                  name: { label: 'name',       is_visible: true,  is_sortable: true,  is_filterable: true, },
                 email: { label: 'email',      is_visible: true,  is_sortable: true,  is_filterable: true, },
              language: { label: 'language',   is_visible: true,  is_sortable: true,  is_filterable: true, },
              password: { label: 'lassword',   is_visible: false, is_sortable: false, is_filterable: false, },
            created_at: { label: 'created_at', is_visible: false, is_sortable: false, is_filterable: false, },
            updated_at: { label: 'updated_at', is_visible: false, is_sortable: false, is_filterable: false, },
            deleted_at: { label: 'deleted_at', is_visible: false, is_sortable: false, is_filterable: false, },
                action: { label: 'actions',    is_visible: true,  is_sortable: true,  is_filterable: true, },
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
        //
        getUsers();

        let columns = localStorage.getItem(local_storage_column_key);

        if (columns) {
            columns = JSON.parse(columns); 
            for (const column_name in columns) { 
                state.columns[column_name] = columns[column_name]; 
            }
        }
    });

    // Rendezés
    function sortedUser() {
        return state.Users.sort((a, b) => {
            return a.user.localeCompare(b.user);
        });
    };

    // Szűrés
    function filteredUsers() {
        return state.Users.filter((user) => {
            return user.user.toLowerCase().includes(state.filters.search.toLowerCase());
        });
    };

    // Kiválasztás
    function select() {
        state.selected = [];
        if (!state.selectAll) {
            state.Users.forEach(user => { state.selected.push(user.id); });
        }
    };

    // Táblázat adatainak lekérése
    function getUsers(){
        axios.post(route('getUsers', {
            filters: state.filters, config: { per_page: state.pagination.per_page, }, page
        }))
        .then(response => {
            state.Users = response.data.users.data;
            state.pagination.total_number_of_pages = response.data.users.last_page;
            state.pagination.current_page = response.data.users.current_page;
        })
        .catch(errors => {});
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
        conformButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
    });

    // Törlés előkészítése
    function deleteUser_init(user){
        delete_alert.fire({
            text: trans('user_delete_confirmation', {name: user.name}),
            confirmButtonText: trans('yes'),
            showDenyButton: false,
            denyButtonText: trans('deny'),
            showCancelButton: true,
            cancelButtonText: trans('cancel')
        }).then(result => {
            //
            if( result.isConfirmed ){
                // Törlendő elem eltárolása
                state.deletingUser = user;
                // Törlési folyamat
                deleteUser(user);
            } else if( result.isDenied ){
                // Megtagadás
                alerta.fire(trans('denied'), '', 'info');
            } else if( result.isDismissed ){
                // Elutasítás
                alerta.fire(trans('dismissed'), '', 'info');
            }
        });
    };

    // Rekord törlése
    function deleteUser(user){
        axios.delete('users_destroy', {user: user})
        .then(response => {
            state.Users = state.Users.filter(user => user.id!== state.deletingUser.id);
            state.deletingUser = null;
            alerta.fire(trans('delete'), '', 'success');
        })
        .catch(errors => {
            alerta.fire({
                icon: 'error',
                title: trans('delete_error'),
                text: errors.response.data.message,
            });
        });
    };

    // Beállítások előkészítése
    function settings_init() { openSettingsModal(); }
    // SETTINGS MODAL megnyitása
    function openSettingsModal() { state.showSettingsModal = true; }
    // SETTINGS MODAL bezárása
    function closeSettingsModal() { state.showSettingsModal = false; };

</script>

<template>
    <AppLayout title="$t('users')">

        <!-- header -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('users') }}</h2>
        </template>

        <!-- Új elem felvitelle -->
        <div class="py-6" style="padding-bottom: 0px;">
            
            <!-- Új elem -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <div class="flex justify-between items=center">
                        
                        <!-- FELIRAT -->
                        <div class="flex space-x-2 items-center">{{ $t('users_description') }}</div>
                        
                        <!-- GOMBOK -->
                        <div class="flex space-x-2 items-center">
                            <DefaultButton type="button" size="text-base" @click="settings_init">{{ $t('setup') }}</DefaultButton>
                            <GreenLink type="button" :href="route('subdomains_create')">+ {{ $t('subdomains_new') }}</GreenLink>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </AppLayout>

    <!-- "Settings" modal -->
    <dialog-modal :show="state.showSettingsModal" id="settings_modal">
        <template #header>{{ $t('setup') }}</template>
        <template #content>
            <div v-for="(config, column) in state.columns" :key="column" 
                class="d-flex align-items-center">
                <input v-model="config.is_visible" :id="column" class="me-3" type="checkbox" />
                <label :for="column">{{ $t(config.label) }}</label>
            </div>
        </template>
        <template #footer>
            <light-button size="text-xs" type="button" @click="closeSettingsModal()"
            >{{ $t('back') }}</light-button>
        </template>
    </dialog-modal>


</template>
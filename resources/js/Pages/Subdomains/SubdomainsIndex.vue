<script setup>
    import { reactive, onMounted, watch, ref } from 'vue';
    import axios from 'axios';

    //import { initFlowbite } from 'flowbite';

    import AppLayout from '../../Layouts/AppLayout.vue';
    //import SubdomainForm from '../../Components/Subdomain/form.vue';
    import DialogModal from '@/Components/DialogModal.vue';

    import VPagination from '@hennge/vue3-pagination';
    import '@hennge/vue3-pagination/dist/vue3-pagination.css';

    //import SecondaryButton from '@/Components/SecondaryButton.vue';
    //import PrimaryButton from '@/Components/PrimaryButton.vue';
    import DefaultButton from '../../Components/buttons/DefaultButton.vue';
    //import GreenButton from '../../Components/buttons/GreenButton.vue';
    import RedButton from '../../Components/buttons/RedButton.vue';
    import LightButton from '../../Components/buttons/LightButton.vue';

    import SorterIcon from '../../Components/icons/SorterIcon.vue';
    //import EditIcon from '../../Components/icons/EditIcon.vue';
    //import DeleteIcon from '../../Components/icons/DeleteIcon.vue';

    //import NavLink from '../../Components/NavLink.vue';
    import GreenLink from '../../Components/linkbuttons/GreenLink.vue';
    import GreenButton from '../../Components/buttons/GreenButton.vue';
    
    import { trans } from 'laravel-vue-i18n';
    import Swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    const local_storage_column_key = 'ln_subdomains_grid_columns';

    //const errors = ref('');

    const props = defineProps({
        can: {
            type: Object, default: () => ({}),
        }
    });

    const defaultFormObject = {
        subdomain: null,
        url: null,
        name: null,
        db_host: null,
        db_port: null,
        db_name: null,
        db_user: null,
        db_password: null,
        notification: null,
        state_id: null,
        is_mirror: null,
        sso: null,
        access_control_system: null,
        last_export: null
    };

    const state = reactive({
        // Összes rekord
        Subdomains: [],
        // Kiválasztott rekord
        //Subdomain: newSubdomain(),
        // Szerkeszteni kívánt rekord
        //editingSubdomain: null,
        // Törölni kívánt rekord
        deletingSubdomain: null,

        // Van nyitott ablak
        //isFormOpen: false,
        // A folyamatban levő művelet szerkesztés
        //isEdit: false,

        // "settings" modal megnyitása / bezárása
        showSettingsModal: false,
        // "edit" modal megnyitása / bezárása
        //showEditModal: false,
        // "delete" modal megnyitása / bezárása
        //showDeleteModal: false,

        // Kiválasztott rekordok azonosítója
        selected: [],
        // Összes elem ki van választva
        selectAll: false,

        // Táblázat oszlopai
        columns: {
                      id: { label: '#', is_visible: true, is_sortable: true, is_filterable: true, },
               subdomain: { label: 'subdomain', is_visible: true, is_sortable: true, is_filterable: true, },
                     url: { label: 'subd_url', is_visible: true, is_sortable: true, is_filterable: true, },
                    name: { label: 'name', is_visible: true, is_sortable: true, is_filterable: true, },
                 db_host: { label: 'db_host', is_visible: true, is_sortable: true, is_filterable: true, },
                 db_port: { label: 'db_port', is_visible: true, is_sortable: true, is_filterable: true, },
                 db_name: { label: 'db_name', is_visible: true, is_sortable: true, is_filterable: true, },
                 db_user: { label: 'db_user', is_visible: true, is_sortable: true, is_filterable: true, },
             db_password: { label: 'db_password', is_visible: true, is_sortable: true, is_filterable: true, },
            notification: { label: 'notification', is_visible: true, is_sortable: true, is_filterable: true, },
                state_id: { label: 'state_id', is_visible: true, is_sortable: true, is_filterable: true, },
               is_mirror: { label: 'is_mirror', is_visible: true, is_sortable: true, is_filterable: true, },
                     sso: { label: 'sso', is_visible: true, is_sortable: true, is_filterable: true, },
            access_controll_system: { label: 'access_controll_system', is_visible: true, is_sortable: true, is_filterable: true, },
             last_export: { label: 'last_export', is_visible: true, is_sortable: true, is_filterable: true, },
              created_at: { label: 'created_at', is_visible: false, is_sortable: false, is_filterable: false, },
              updated_at: { label: 'updated_at', is_visible: false, is_sortable: false, is_filterable: false, },
              deleted_at: { label: 'deleted_at', is_visible: false, is_sortable: false, is_filterable: false, },
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
        //initFlowbite();

        getSubdomains();

        let columns = localStorage.getItem(local_storage_column_key);

        if (columns) {
            columns = JSON.parse(columns); 
            for (const column_name in columns) { 
                state.columns[column_name] = columns[column_name]; 
            }
        }
    });

    // Rendezés
    function sortedSubdomain() {
        return state.Subdomains.sort((a, b) => {
            return a.subdomain.localeCompare(b.subdomain);
        });
    };

    // Szűrés
    function filteredSubdomains() {
        return state.Subdomains.filter((subdomain) => {
            return subdomain.subdomain.toLowerCase().includes(state.filters.search.toLowerCase());
        });
    };

    // Kiválasztás
    function select() {
        state.selected = [];
        if (!state.selectAll) {
            state.Subdomains.forEach(subdomain => { state.selected.push(subdomain.id); });
        }
    };

    // Táblázat adatainak lekérése
    function getSubdomains(page = state.pagination.current_page) {
        axios.post(route('getSubdomains', {
            filters: state.filters, config: { per_page: state.pagination.per_page, }, page
        }))
        .then(response => {
            state.Subdomains = response.data.subdomains.data; 
            state.pagination.total_number_of_pages = response.data.subdomains.last_page; 
            state.pagination.current_page = response.data.subdomains.current_page;
        });
    }

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

    // Törlés előkészítése
    function deleteSubdomain_init(subdomain){
        
        // Figyelmeztető ablak megjelenítése
        delete_alert.fire({
            // Ablak felirata
            text: trans('subdomains_delete_confirmation', {name: subdomain.subdomain}),
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
                state.deletingSubdomain = subdomain;
                // Törlés végrehajtása
                deleteSubdomain(subdomain);
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
    function deleteSubdomain(subdomain) {
        //console.log(subdomain);
        axios.delete(route('subdomains_destroy', { subdomain: subdomain }))
            .then((response) => {
                
                console.log(state.Subdomains);
                console.log(state.deletingSubdomain);

                state.Subdomains = state.Subdomains.filter(subdomain => subdomain.id !== state.deletingSubdomain.id); 
                state.deletingSubdomain = null;
                //openDeleteModal();
                alerta.fire(trans('delete'), '', 'success');
            })
            .catch((error) => {
                console.log('error');
                console.log(error);
                //alerta.fire(trans('delete'), '', 'error');
            });
    }

    // Szerkesztés megszakítása
    //function cancelEdit(){
    //    state.editingSubdomain = null;
    //    state.Subdomain = newSubdomain();
    //}

    // Beállítások előkészítése
    function settings_init() { openSettingsModal(); }
    // SETTINGS MODAL megnyitása
    function openSettingsModal() { state.showSettingsModal = true; }
    // SETTINGS MODAL bezárása
    function closeSettingsModal() { state.showSettingsModal = false; }
    // DELETE MODAL megnyitása
    //function openDeleteModal() { state.showDeleteModal = true; }
    // DELETE MODAL bezárása
    //function closeDeleteModal() { state.showDeleteModal = false; }
</script>

<template>
    <AppLayout :title="$t('subdomains')">

        <!-- header -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"
            >{{ $t('subdomains') }}</h2>
        </template>

        <!-- Új elem felvitelle -->
        <div class="py-6" style="padding-bottom: 0px;">
            
            <!-- Új elem -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <div class="flex justify-between items=center">
                        
                        <!-- FELIRAT -->
                        <div class="flex space-x-2 items-center">{{ $t('subdomains_description') }}</div>
                        
                        <!-- GOMBOK -->
                        <div class="flex space-x-2 items-center">
                            
                            <!-- "beállítások" gomb -->
                            <DefaultButton type="button" size="text-base" 
                                @click="settings_init">{{ $t('setup') }}</DefaultButton>
                            
                            <!--
                                "Új subdomain" gomb
                                "create" jogosultság vizsgálata
                            -->
                            <GreenLink v-if="can.create"
                                type="button" 
                                :href="route('subdomains_create')"
                            >+ {{ $t('subdomains_new') }}</GreenLink>

                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- Aldomainek listája -->
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
                                <tr class="bg-gray-100">
                                    
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

                                    <!-- SUBDOMAIN -->
                                    <th scope="col" class="px-6 py-3" 
                                        v-show="state.columns.subdomain.is_visible">
                                        <div class="flex items-center">
                                            {{ $t(state.columns.subdomain.label) }}
                                            <a href="#" v-show="state.columns.subdomain.is_sortable">
                                                <SorterIcon />
                                            </a>
                                        </div>
                                    </th>

                                    <!-- URL -->
                                    <th scope="col" class="px-6 py-3" 
                                        v-show="state.columns.url.is_visible">
                                        <div class="flex items-center">
                                            {{ $t(state.columns.url.label) }}
                                            <a href="#" v-show="state.columns.url.is_sortable">
                                                <SorterIcon />
                                            </a>
                                        </div>
                                    </th>

                                    <!-- IMAGE -->
                                    <th scope="col" class="px-6 py-3" 
                                        v-show="state.columns.name.is_visible">
                                        <div class="flex items-center">
                                            {{ $t(state.columns.name.label) }}
                                            <a href="#" v-show="state.columns.name.is_sortable">
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
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="subdomain in state.Subdomains">
                                    <td class="px-6 py-3 border">
                                        <div>
                                            <input :id="subdomain.id" 
                                                type="checkbox" 
                                                :value="subdomain.id"
                                                :key="subdomain.id" 
                                                v-model="state.selected"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500
                                                    dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800
                                                    focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                            <label class="sr-only" 
                                                :for="subdomain.id">checkbox</label>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 border" v-show="state.columns.id.is_visible">{{ subdomain.id }}</td>
                                    <td class="px-4 py-2 border" v-show="state.columns.subdomain.is_visible">{{ subdomain.subdomain }}</td>
                                    <td class="px-4 py-2 border" v-show="state.columns.url.is_visible">{{ subdomain.url }}</td>
                                    <td class="px-4 py-2 border" v-show="state.columns.name.is_visible">{{ subdomain.name }}</td>

                                    <td class="px-4 py-2 w-45 border items-center" width="250px" v-show="state.columns.action.is_visible">
                                        <div class="flex items-center">
                                            <!-- SZERKESZTÉS -->
                                            <green-link v-if="can.edit" 
                                                        :href="route('subdomains_edit', subdomain.id)"
                                            >{{ $t('edit') }}</green-link>

                                            <!-- TÖRLÉS -->
                                            <red-button v-if="can.delete"
                                                        @click="deleteSubdomain_init(subdomain)"
                                            >{{ $t('delete') }}</red-button>
                                        </div>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination -->
                    <div
                        class="mb-3 bg-white shadow bg-body rounded w-75 ln-max-width mx-auto p-3 d-flex align-items-center justify-content-center">
                        <v-pagination v-model="state.pagination.current_page"
                            :pages="state.pagination.total_number_of_pages" 
                            :range-size="state.pagination.range"
                            active-color="#DCEDFF" @update:modelValue="getSubdomains" />
                    </div>

                </div>
            </div>
        </div>

    </AppLayout>

    <!-- CONFIRM DELETE MODAL -->
    <!--
    <dialog-modal :show="state.showDeleteModal" id="delete_modal">
        <template #subdomain> {{ $t('subdomains_delete') }}
        </template>
        <template #content> {{ $t('subdomains_delete_confirmation') }}
        </template>
        <template #footer>
            <light-button size="text-xs" type="button" @click="closeDeleteModal()">{{ $t('cancel') }}</light-button>
            <red-button size="text-xs" type="button" @click="deleteSubdomain()">{{ $t('delete') }}</red-button>
        </template>
    </dialog-modal>
    -->

    <!-- SETTINGS MODAL -->
    <dialog-modal :show="state.showSettingsModal" id="settings_modal">
        <template #header>{{ $t('setup') }}</template>
        <template #content>
            <div v-for="(config, column) in state.columns" 
                 :key="column" 
                 class="d-flex align-items-center">
                <input v-model="config.is_visible" 
                       :id="column" 
                       class="me-3" 
                       type="checkbox" />
                    <label :for="column">{{ $t(config.label) }}</label>
                </div>
        </template>
        <template #footer> <light-button size="text-xs" type="button" @click="closeSettingsModal()">{{ $t('back')
                }}</light-button>
        </template>
    </dialog-modal>
</template>
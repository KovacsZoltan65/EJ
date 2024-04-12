<script setup>
    import { router, useForm } from '@inertiajs/vue3';
    //import { onMounted } from 'vue';
    //import axios from 'axios';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import InputError from '@/Components/InputError.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectInput from '@/Components/SelectInput.vue';

    //import DefaultButton from '@/Components/buttons/DefaultButton.vue';
    import GreenButton from '@/Components/buttons/GreenButton.vue';
    //import GreenLink from '@/Components/linkbuttons/GreenLink.vue';
    import DefaultLink from '@/Components/linkbuttons/DefaultLink.vue';

    import { trans } from 'laravel-vue-i18n';
    import Swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    // Általános alert
    const alerta = Swal.mixin({
        buttonsStyling: true
    });

    // Mentés alert
    const save_alert = Swal.mixin({
        buttonsStyling: true
    });

    // Tulajdonságok
    const props = defineProps({
        can: {
            type: Object,
            required: true,
        },
        user: {
            type: Object,
            required: true,
        },
        roles: {
            type: Object,
            required: true,
        },
        permissions: {
            type: Object,
            required: true,
        },
    });

    //onMounted(() => {
        //console.log(props.user);
        //console.log(form);
    //});

    const languages = [
        {id: 'en', name: 'English'},
        {id: 'hu', name: 'Hungarian'},
    ];

    // Form adatai
    const form = useForm({
            name: props.user.name,
           email: props.user.email,
        language: props.user.language,
        password: props.user.password,
        password_confirmation: '',
           roles: props.user.roles,
        permissions: props.user.permissions,
    });

    // Mentés
    const submit = () => {

        form.post(route('users_store'), {
            onSuccess: (response) => {
                // Üzenet
                save_alert.fire({
                    // Ablak felirata
                    text: trans('save_success'),
                    // "Megerősítés" gomb felirata
                    confirmButtonText: trans('back_to_list'),
                    // "Elutasítás" gomb megjelenítése
                    showDenyButton: true,
                    // "Elutasítás" gomb felirata
                    denyButtonText: trans('users_new')
                }).then((result) => {
                    // Vissza a listához
                    if( result.isConfirmed ) {
                        console.log('Listához');
                        window.location.href = route('users');
                    }
                    // Adatrögzítés folytatása
                    else if( result.isDenied ) {
                        //console.log('Create new');
                    } else if( result.isDismissed ) {
                        //
                    }
                });
                //console.log('onSuccess'); 
            },
            onFinish: (values) => {
                console.log('onFinish');
                form.reset();
            },
            onError: (errors) => {
                console.log('onError');
            },
            preserveScroll: true
        });
        
    };
</script>

<template>
    <AppLayout :title="$t('users_create')">

        <!-- header -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('users_create') }}
            </h2>
        </template>

        <!-- FORM -->
        <div class="py-6">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <!-- <form @submit.prevent="$event => form.post(route('users_store'))"> -->
                    <form @submit.prevent="submit">
                        
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <!-- NAME -->
                            <div>
                                <InputLabel 
                                        for="name" 
                                        class="block mb-2 text-sm font-medium 
                                            text-gray-900 dark:text-white"
                                >{{ $t('name') }}</InputLabel>
                                <TextInput 
                                    v-model="form.name" type="text" 
                                    id="name" name="name" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                                            dark:focus:border-blue-500" 
                                    :placeholder="$t('name')" ></TextInput>
                                <InputError :message="form.errors.name"></InputError>
                            </div>

                            <!-- EMAIL -->
                            <div>
                                <InputLabel 
                                    for="email" 
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >{{ $t('email') }}</InputLabel>
                                <TextInput v-model="form.email"
                                    type="email" id="email" name="email" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                            focus:ring-blue-500 focus:border-blue-500 
                                            block w-full p-2.5 
                                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    :placeholder="$t('email')" ></TextInput>
                                <InputError :message="form.errors.email"></InputError>
                            </div>

                            <!-- LANGUAGE -->
                            <div>
                                <InputLabel 
                                    for="language" 
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >{{ $t('language') }}</InputLabel>
                                <SelectInput v-model="form.language"
                                    :options="languages"
                                    :seleced="form.language"
                                    id="language" name="language" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                        focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 
                                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 
                                        dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                ></SelectInput>
                                <InputError :message="form.errors.name"></InputError>
                            </div>

                        </div>

                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                        
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <!-- PASSWORD -->
                            <div>
                                <InputLabel 
                                        for="password" 
                                        class="block mb-2 text-sm font-medium 
                                            text-gray-900 dark:text-white"
                                >{{ $t('password') }}</InputLabel>
                                <TextInput 
                                    v-model="form.password" type="text" 
                                    id="password" name="password" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                                            dark:focus:border-blue-500" 
                                    :placeholder="$t('password')" ></TextInput>
                                <InputError :message="form.errors.password" />
                            </div>

                            <!-- password_confirmation -->
                            <div>
                                <InputLabel 
                                    for="password_confirmation" 
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >{{ $t('password_confirmation') }}</InputLabel>
                                <TextInput v-model="form.password_confirmation"
                                    type="password_confirmation" id="password_confirmation" name="password_confirmation" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                            focus:ring-blue-500 focus:border-blue-500 
                                            block w-full p-2.5 
                                            dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                    :placeholder="$t('password_confirmation')" ></TextInput>
                                <InputError :message="form.errors.password_confirmation" />
                            </div>
                        </div>

                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <!-- ROLES -->
                            <div>
                                <InputLabel>{{ $t('roles') }}</InputLabel>
                                <SelectInput v-model="form.roles"
                                    :options="props.roles"
                                    :selected="1"
                                    id="roles" name="roles" multiple
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                                            dark:focus:border-blue-500"
                                />
                            </div>

                            <!-- PERMISSIONS -->
                            <div>
                                <InputLabel>{{ $t('permissions') }}</InputLabel>
                                <SelectInput v-model="form.permissions"
                                    :options="props.permissions"
                                    :selected="1"
                                    id="permissions" name="permissions" multiple
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                                            dark:focus:border-blue-500"
                                />
                            </div>

                        </div>

                        <!-- "Submit" button -->
                        <GreenButton type="submit" 
                            size="text-base" :title="$t('save')"
                        >{{ $t('save') }}</GreenButton>

                        <!-- "Cancel" button -->
                        <DefaultLink type="button" class="float-right" 
                            :href="route('users')" :title="$t('back')"
                        >{{ $t('back') }}</DefaultLink>
                    </form>

                </div>
            </div>
        </div>

    </AppLayout>
</template>
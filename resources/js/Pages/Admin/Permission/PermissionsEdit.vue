<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import InputError from '@/Components/InputError.vue';
    import TextInput from '@/Components/TextInput.vue';
    import SelectInput from '@/Components/SelectInput.vue';

    import DefaultButton from '@/Components/buttons/DefaultButton.vue';
    import GreenButton from '@/Components/buttons/GreenButton.vue';
    import GreenLink from '@/Components/linkbuttons/GreenLink.vue';
    import DefaultLink from '@/Components/linkbuttons/DefaultLink.vue';

    import { trans } from 'laravel-vue-i18n';
    import Swal from 'sweetalert2';
    import 'sweetalert2/dist/sweetalert2.min.css';

    // Általános alert
    const alerta = Swal.mixin({
        buttonsStyling: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
    });

    // Mentés alert
    const save_alert = Swal.mixin({
        buttonsStyling: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        icon: 'question'
    });

    const props = defineProps({
        can: {
            type: Object,
            required: true,
        },
        permission: {
            type: Object,
            required: true,
        }
    });

    const form = useForm({
        name: props.permission.name,
        guard_name: props.permission.guard_name,
    });

    const submit = () => {
        form.patch(route('routes_ubdate', props.permission.id), {
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
                    denyButtonText: trans('permissions_edit')
                }).then((result) => {
                    // Vissza a listához
                    if( result.isConfirmed ) {
                        console.log('Listához');
                        window.location.href = route('permissions');
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
    <AppLayout :title="$t('permissions_edit')">

        <!-- header -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $t('permissions_edit') }}
            </h2>
        </template>

        <div class="py-6">
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                    <form @submit.prevent="submit">
                        <div class="grid gap-6 mb-6 md:grid-cols-2">

                            <!-- NAME -->
                            <div>
                                <InputLabel 
                                        for="name" 
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >{{ $t('name') }}</InputLabel>
                                <TextInput 
                                    v-model="form.name" type="text" 
                                    id="name" name="name" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                                            dark:focus:border-blue-500" 
                                    :placeholder="$t('name')" required />
                                    <InputError :message="form.errors.name" />
                            </div>

                            <!-- GUARD_NAME -->
                            <div>
                                <InputLabel 
                                        for="guard_name" 
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                >{{ $t('guard_name') }}</InputLabel>
                                <TextInput 
                                    v-model="form.guard_name" type="text" 
                                    id="guard_name" name="guard_name" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg 
                                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                                            dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 
                                            dark:focus:border-blue-500" 
                                    :placeholder="$t('guard_name')" required />
                                    <InputError :message="form.errors.guard_name" />
                            </div>

                        </div>

                        <!-- "Submit" button -->
                        <GreenButton type="submit" 
                            size="text-base"
                        >{{ $t('save') }}</GreenButton>

                        <!-- "Cancel" button -->
                        <DefaultLink type="button" class="float-right" 
                            :href="route('permissions')"
                        >{{ $t('back') }}</DefaultLink>

                    </form>
                </div>
            </div>
        </div>

    </AppLayout>
</template>
<script setup>
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import AuthenticationCard from '@/Components/AuthenticationCard.vue';
    import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
    import Checkbox from '@/Components/Checkbox.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';

    defineProps({
        canResetPassword: Boolean,
        status: String,
    });

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = () => {
        form.transform(data => ({
            ...data,
            remember: form.remember ? 'on' : '',
        })).post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    };
</script>

<template>
    <Head :title="$t('login')" />

    <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">

            <!-- EMAIL -->
            <div>
                <InputLabel for="email" :value="$t('email')" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- PASSWORD -->
            <div class="mt-4">
                <InputLabel for="password" :value="$t('password')" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                superadmin@laraveltuts.com | password<br/>
                admin@laraveltuts.com | password<br/>
            </div>
            <!-- REMEMBER ME -->
            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ $t('remember_me') }}</span>
                </label>
            </div>

            <!-- RESET PASSWORD & SUBMIT -->
            <div class="flex items-center justify-end mt-4">
                <!-- RESET PASSWORD -->
                <Link v-if="canResetPassword" :href="route('password.request')" 
                      class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ $t('forgot_password') }}
                </Link>

                <!-- SUBMIT -->
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" 
                               :disabled="form.processing">
                    {{ $t('login') }}
                </PrimaryButton>

            </div>
        </form>
    </AuthenticationCard>
</template>

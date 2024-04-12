<script setup>
    import NavLink from '../../Components/NavLink.vue';
    import Dropdown from '@/Components/Dropdown.vue';
    import DropdownLink from '@/Components/DropdownLink.vue';
</script>
<template>
    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

        <!-- dashboard menu -->
        <NavLink :href="route('dashboard')" 
                 :active="route().current('dashboard')">
            {{ $t('dashboard') }}
        </NavLink>

        <!-- ADMIN MENU -->
        <Dropdown align="right" class="py-4 items-center" style="margin-left: 16px;">
            <template #trigger>
                <span class="inline-flex rounded-md">
                    <button type="button" 
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        {{ $t('admin') }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            </template>

            <template #content>
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ $t('manage_admin') }}
                </div>
                <!-- users menu -->
                <DropdownLink :href="route('user.index')"
                              :active="route().current('user.index')">
                    {{ $t('users') }}
                </DropdownLink>
                <!-- permissions menu -->
                <DropdownLink :href="route('permission.index')" 
                              :active="route().current('permission.index')">
                    {{ $t('permissions') }}
                </DropdownLink>
                <!-- roles menu -->
                <DropdownLink :href="route('role.index')" 
                              :active="route().current('role.index')">
                    {{ $t('roles') }}
                </DropdownLink>
            </template>
        </Dropdown>

        <!-- PÉLDÁNYOK MENU -->
        <Dropdown align="right" class="py-4 items-center" style="margin-left: 16px;">
            <template #trigger>
                <span class="inline-flex rounded-md">
                    <button type="button" 
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                        {{ $t('specimen') }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            </template>

            <template #content>
                <!-- Specimen Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ $t('manage_specimen') }}
                </div>

                <!-- subdomains menu -->
                <DropdownLink :href="route('subdomains')"
                              :active="route().current('subdomains')">
                    {{ $t('subdomains') }}
                </DropdownLink>

                <!-- companies menu -->
                <DropdownLink :href="route('companies.index')" 
                              :active="route().current('companies.index')">
                    {{ $t('companies') }}
                </DropdownLink>
                <!-- external admins menu -->
                <DropdownLink :href="route('external_admins.index')" 
                              :active="route().current('external_admins.index')">
                    {{ $t('external_admins') }}
                </DropdownLink>
            </template>
        </Dropdown>

        <!-- books menu -->
        <NavLink :href="route('books')" 
                 :active="route().current('books')">
            {{ $t('books') }}
        </NavLink>

        <!-- users menu -->
        <!--<NavLink :href="route('user.index')" 
                 :active="route().current('user.index')">
            {{ $t('users') }}
        </NavLink>-->

        <!-- permissions menu -->
        <!--<NavLink :href="route('permission.index')" 
                 :active="route().current('permission.index')">
            {{ $t('permissions') }}
        </NavLink>-->

        <!-- roles menu -->
        <!--<NavLink :href="route('role.index')" 
                 :active="route().current('role.index')">
            {{ $t('roles') }}
        </NavLink>-->

        <!-- subdomains menu -->
        <!--<NavLink :href="route('subdomains')" 
                 :active="route().current('subdomains')">
            {{ $t('subdomains') }}
        </NavLink>-->

        <!-- posts menu -->
        <NavLink :href="route('post.index')" 
                 :active="route().current('post.index')">
            {{ $t('posts') }}
        </NavLink>
    </div>
</template>
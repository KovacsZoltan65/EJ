<script setup>
    import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
</script>

<template>
    <div class="pt-2 pb-3 space-y-1">

        <!-- dashboard menu -->
        <ResponsiveNavLink :href="route('dashboard')" 
                           :active="route().current('dashboard')">
            {{ $t('dashboard') }}
        </ResponsiveNavLink>

        <!-- books menu -->
        <ResponsiveNavLink :href="route('books')" 
                           :active="route().current('books')">
            {{ $t('books') }}
        </ResponsiveNavLink>

        <!-- users menu -->
        <ResponsiveNavLink :href="route('user.index')" 
                           :active="route().current('users')">
            {{ $t('users') }}
        </ResponsiveNavLink>

        <!-- subdomains menu -->
        <ResponsiveNavLink :href="route('subdomains')" 
                           :active="route().current('subdomains')">
            {{ $t('subdomains') }}
        </ResponsiveNavLink>

        <!-- permissions menu -->
        <ResponsiveNavLink :href="route('permission.index')" 
                           :active="route().current('permissions')">
            {{ $t('permissions') }}
        </ResponsiveNavLink>

        <!-- roles menu -->
        <ResponsiveNavLink :href="route('role.index')" 
                           :active="route().current('roles')">
            {{ $t('roles') }}
        </ResponsiveNavLink>

        <!-- posts menu -->
        <ResponsiveNavLink :href="route('post.index')" 
                           :active="route().current('posts')">
            {{ $t('posts') }}
        </ResponsiveNavLink>

    </div>
</template>
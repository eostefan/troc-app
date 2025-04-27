<template>
    <header class="flex justify-between fixed w-full py-4 px-4 bg-slate-800 border-b-1 border-slate-600 z-10">
        <Link :href="route('items.index')" class="text-slate-300"><strong>TROC APP</strong></Link>

        <nav v-if="isAuth" class="flex gap-4 text-slate-100">
            <Link :href="route('profile.items.index')">{{ page.props.user.name }}</Link>
            <Link :href="route('profile.items.create')">Add new</Link>
            <Link :href="route('logout')" method="delete" as="button">Logout</Link>
        </nav>

        <nav v-else class="flex gap-4 text-slate-100">
            <Link :href="route('login')">Login</Link>
            <Link :href="route('register')">Register</Link>
        </nav>
    </header>

    <p v-if="showFlashMessage" class="fixed z-10 top-18 left-1/2 -translate-x-1/2 w-full max-w-95 mx-auto text-center py-1 bg-green-900 text-green-400">
        {{ flashMessage }}
    </p>

    <main class="pt-18 md:w-120 mx-auto">
        <slot></slot>
    </main>
</template>

<script setup>

import { ref, computed, watch } from 'vue';
import { route } from 'ziggy-js';
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
const flashMessage = computed(() => page.props.flash.success)
const isAuth = computed(() => page.props.user)
const showFlashMessage = ref(false)

watch(flashMessage, (newV) => {
    if (newV) showFlashMessage.value = true
    setTimeout(() => showFlashMessage.value = false, 1500)
})

</script>

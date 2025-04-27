<template>
    <section class="login px-4">
        <form @submit.prevent="doLogin" class="flex flex-col gap-2">
            <div class="form-control">
                <label for="email">Email</label>
                <input type="email" id="email" v-model="loginData.email" autocomplete="new-email">
                <p v-if="loginData.errors.email" v-html="loginData.errors.email" class="text-xs text-red-700 mt-1"></p>
            </div>
            <div class="form-control">
                <label for="password">Password</label>
                <input type="password" id="password" v-model="loginData.password" autocomplete="new-password">
                <p v-if="loginData.errors.password" v-html="loginData.errors.password" class="text-xs text-red-700 mt-1"></p>
            </div>
            <div class="form-control mt-4">
                <button type="submit" class="form-confirm">Login</button>
            </div>
        </form>
    </section>
</template>

<script setup>
import { route } from 'ziggy-js';
import { useForm } from '@inertiajs/vue3';

const loginData = useForm({
    email: null,
    password: null
})

const doLogin = () => {
    loginData.post(route('login.store'))
}
</script>

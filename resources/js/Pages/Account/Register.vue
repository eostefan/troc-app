<template>
    <section class="register px-4">
        <form @submit.prevent="registerForm" class="flex flex-col gap-2">
            <div class="form-control">
                <label for="name">Name</label>
                <input type="text" id="name" autocomplete="new-name" v-model="registerData.name">
                <p v-if="registerData.errors.name" v-html="registerData.errors.name" class="text-xs text-red-700 mt-1"></p>
            </div>
            <div class="form-control">
                <label for="email">E-mail</label>
                <input type="email" id="email" autocomplete="new-email" v-model="registerData.email">
                <p v-if="registerData.errors.email" v-html="registerData.errors.email" class="text-xs text-red-700 mt-1"></p>
            </div>
            <div class="form-control">
                <label for="password">Password</label>
                <input type="password" id="password" autocomplete="new-pass" v-model="registerData.password">
                <p v-if="registerData.errors.password" v-html="registerData.errors.password" class="text-xs text-red-700 mt-1"></p>
            </div>
            <div class="form-control">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" autocomplete="new-confirm" v-model="registerData.password_confirmation">
                <p v-if="registerData.errors.password_confirmation" v-html="registerData.errors.password_confirmation" class="text-xs text-red-700 mt-1"></p>
            </div>
            <div class="form-control mt-4">
                <button type="submit" class="form-confirm">
                    Register
                </button>
            </div>
        </form>
    </section>
</template>

<script setup>

import { useForm } from '@inertiajs/vue3';

const registerData = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null
})

const registerForm = () => registerData.post(route('register.store'))

</script>

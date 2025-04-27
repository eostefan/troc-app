<template>
    <section class="create-item-box px-4">
        <h2 class="font-bold text-l text-slate-300 mb-4">Create item</h2>

        <form @submit.prevent="createItem">
            <div class="form-control mt-4">
                <h3 class="text-slate-300 pb-1 mb-1 border-b-1 border-b-slate-300">images</h3>
            </div>
            <div class="form-control text-white my-4">
                <input type="file" 
                        multiple 
                        name="images" 
                        id="images" 
                        class="w-full text-sm border-1 border-slate-300 file:bg-slate-500 file:p-1.5 rounded"
                        @input="getUploadedFile($event)">
            </div>
            <div class="form-control">
                <h3 class="text-slate-300 pb-1 mb-1 border-b-1 border-b-slate-300">details</h3>
            </div>
            <div class="form-control">
                <label for="name">Name</label>
                <input type="text" v-model="itemData.name">
                <p v-if="itemData.errors.name" v-html="itemData.errors.name" class="text-xs text-red-700 mt-1"></p>
            </div>
            <div class="form-control">
                <label for="description">Description</label>
                <input type="text" v-model="itemData.description">
                <p v-if="itemData.errors.description" v-html="itemData.errors.description" class="text-xs text-red-700 mt-1"></p>
            </div>
            <div class="form-control mt-4">
                <h3 class="text-slate-300 pb-1 mb-1 border-b-1 border-b-slate-200">location</h3>
            </div>
            <div class="form-group flex gap-2">
                <div class="form-control w-full">
                    <label for="county">County</label>
                    <select name="county" v-model="itemData['address.county']" id="county">
                        <option selected>CHOOSE</option>
                        <option v-for="judet in utils.judete" :key="judet" :value="judet">{{ judet }}</option>
                    </select>
                    <p v-if="itemData.errors['address.county']" v-html="itemData.errors['address.county']" class="text-xs text-red-700 mt-1"></p>
                </div>
                <div class="form-control w-full" v-if="itemData['address.county'] === 'Bucuresti'">
                    <label for="sector">Sector</label>
                    <select name="sector" v-model="itemData['address.sector']" id="sector">
                        <option value="CHOOSE" selected>CHOOSE</option>
                        <option value="SECTOR 1">Sector 1</option>
                        <option value="SECTOR 2">Sector 2</option>
                        <option value="SECTOR 3">Sector 3</option>
                        <option value="SECTOR 4">Sector 4</option>
                        <option value="SECTOR 5">Sector 5</option>
                        <option value="SECTOR 6">Sector 6</option>
                    </select>
                    <p v-if="itemData.errors['address.sector']" v-html="itemData.errors['address.sector']" class="text-xs text-red-700 mt-1"></p>
                </div>
            </div>
            <div class="form-control flex gap-2 mt-6">
                <button type="submit" class="form-confirm">Create</button>
                <button type="reset" class="form-confirm" @click="goBack">Back</button>
            </div>
        </form>
    </section>
</template>

<script setup>
import { route } from 'ziggy-js';
import { useForm } from '@inertiajs/vue3';
import utils from './../../util/utils.js'

const itemData = useForm({
    name: null,
    description: null,
    images: [],
    'address.county': null,
    'address.sector': null
})

const createItem = () => itemData.post(route('profile.items.store'));
const getUploadedFile = (ev) => {
    if (ev.target.files && ev.target.files.length ) {
        for(let file of ev.target.files) {
            itemData.images.push(file)
        }
    }
}
const goBack = () => window.history.back()

</script>

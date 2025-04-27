<template>
    <section class="update-item-box w-full px-4">
        <h2 class="font-bold text-slate-300 mb-4">Update</h2>

        <form @submit.prevent="updateItem" enctype="multipart/form-data">
            <div class="form-control mt-4">
                <h3 class="text-slate-300 pb-1 mb-1 border-b-1 border-b-slate-200">images</h3>
            </div>
            <div class="form-control text-white my-4">
                <input type="file" 
                        multiple 
                        name="images" 
                        id="images" 
                        class="w-full text-sm border-1 border-slate-300 file:bg-slate-500 file:p-1.5 rounded"
                        @change="getUploadedFile($event)">
                <p v-if="itemData.errors['images.0']" class="text-xs text-red-700 mt-1">{{ itemData.errors['images.0'] }}</p>
            </div>
            <div class="form-control">
                <h3 class="text-slate-300 pb-1 mb-1 border-b-1 border-b-slate-200">details</h3>
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
                <h3 class="text-slate-300 pb-1 mb-1 border-b-1 border-b-slate-200">address</h3>
            </div>
            <div class="form-group flex gap-2">
                <div class="form-control w-full">
                    <label for="county">County</label>
                    <select name="county" v-model="itemData.address.county" id="county">
                        <option selected>CHOOSE</option>
                        <option v-for="county in utils.judete" :key="county" :value="county">{{ county }}</option>
                    </select>
                    <p v-if="itemData.errors['address.county']" v-html="itemData.errors.address.county" class="text-xs text-red-700 mt-1"></p>
                </div>
                <div class="form-control w-full" v-if="itemData.address.county === 'Bucuresti'">
                    <label for="sector">Sector</label>
                    <select name="sector" v-model="itemData.address.sector" id="sector">
                        <option value="SECTOR 1">Sector 1</option>
                        <option value="SECTOR 2">Sector 2</option>
                        <option value="SECTOR 3">Sector 3</option>
                        <option value="SECTOR 4">Sector 4</option>
                        <option value="SECTOR 5">Sector 5</option>
                        <option value="SECTOR 6">Sector 6</option>
                    </select>
                    <p v-if="itemData.errors['address.sector']" v-html="itemData.errors.address.sector" class="text-xs text-red-700 mt-1"></p>
                </div>
            </div>

            <div class="form-control flex gap-2 mt-6">
                <button type="submit" class="form-confirm">Update</button>
                <button type="reset" class="form-confirm" @click="goBack">Back</button>
            </div>
        </form>

        <div class="uploaded-images mt-6 flex flex-col flex-wrap mb-6" v-if="props.item.photos.length">
            <h3 class="text-slate-300 mb-2">Manage images</h3>

            <div class="uploaded-image relative w-1/2" v-for="image in props.item.photos" :key="image.id">
                <img :src="image.url" :alt="image.filename" class="w-full object-cover" />
                <Link 
                    :href="route('profile.photos.destroy', { photo: image.id })" 
                    as="button" method="DELETE"
                    class="small-close-btn">&times;</Link>
            </div>
        </div>
    </section>
</template>

<script setup>
import { route } from 'ziggy-js';
import { useForm, Link } from '@inertiajs/vue3';
import utils from './../../util/utils.js'

const props = defineProps({
    item: Object
})

const itemData = useForm({
    name: props.item.name || null,
    description: props.item.description || null,
    images: [],
    address: {
        county: props.item.address?.county || null,
        sector: props.item.address?.sector || null
    }
})

const updateItem = () => {

    const data = new FormData()
    data.append('name', itemData.name)
    data.append('description', itemData.description)

    // Flatten address object
    for (const key in itemData.address) {
        data.append(`address[${key}]`, itemData.address[key])
    }

    // Append files if any
    itemData.images.forEach((file, index) => {
        data.append(`images[${index}]`, file)
    })

    itemData.post(
        route('profile.items.update', { item: props.item }), 
        { 
            preserveScroll: true, 
            forceFormData: true, 
            method: 'put' 
        }
    )
}

const getUploadedFile = (e) => {
    itemData.images = Array.from(e.target.files)
}

const goBack = () => window.history.back()

</script>

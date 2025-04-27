<template>

    <section class="items flex flex-col gap-3 px-2">

        <button class="form-confirm w-full mt-2" @click="toggleFiltersVisible">filtering collapse/expand</button>

        <div class="items-filters mb-4" v-if="filtering_visible">
            <form @submit.prevent="applyFilters">
                <h3 class="text-slate-300 text-md mb-2 pb-1 border-b-1 border-slate-400">Region</h3>
                <div class="form-group mb-6" :class="filteringData.county === 'Bucuresti' && 'flex gap-2'">
                    <div class="form-control">
                        <label for="county">County</label>
                        <select name="county" id="county" v-model="filteringData.county">
                            <option v-for="county in utils.judete" :key="county" :value="county">
                                {{  county }}
                            </option>
                        </select>
                    </div>
                    <div class="form-control" v-if="filteringData.county === 'Bucuresti'">
                        <label for="sector">Sector</label>
                        <select name="sector" v-model="filteringData.sector" id="sector">
                            <option value="SECTOR 1">Sector 1</option>
                            <option value="SECTOR 2">Sector 2</option>
                            <option value="SECTOR 3">Sector 3</option>
                            <option value="SECTOR 4">Sector 4</option>
                            <option value="SECTOR 5">Sector 5</option>
                            <option value="SECTOR 6">Sector 6</option>
                        </select>
                    </div>
                </div>
                <h3 class="text-slate-300 text-md mb-2 pb-1 border-b-1 border-slate-400">Categories</h3>
                <div class="form-control flex flex-wrap gap-y-1 gap-x-2 mb-4">
                    <label :for="category.name" v-for="category in props.categories" :key="category.id"
                            class="filter-check relative p-2 border-1 border-slate-500 rounded">
                        <input type="checkbox" 
                            :name="category.name" 
                            :id="category.name" 
                            :value="category.name"
                            @change="storeSelectedCategories($event)"
                            class="filter-checkbox pointer-events-none w-0 h-0">
                        <span class="selected-checkbox"></span>
                        {{ category.name }}
                    </label>
                </div>
                <div class="form-control flex gap-2 mt-2 pt-2 border-t-1 border-slate-400">
                    <button class="form-confirm w-1/2" type="submit">filter</button>
                    <button class="form-confirm w-1/2" @click="resetFilters" type="reset">reset</button>
                </div>
            </form>

        </div>

        <div class="items-main grid grid-cols-2 grid-rows-auto gap-2 mb-4">
            <div v-for="item in props.items.data" :key="item.id" class="item border-1 rounded-md border-slate-500 overflow-hidden">
                <div class="item-image h-30 bg-center overflow-hidden text-teal-50 mb-2 bg-gray-300">
                    <img v-if="item.photos && item.photos.length" class="object-cover w-full h-full mx-auto" :src="item.photos[0].url" />
                    <img v-else class="object-contain w-full h-auto mx-auto" src="../../../assets/placeholder.png" />
                </div>
                <div class="item-main p-2 mb-auto">
                    <h3 v-html="item.name" class="text-white text-sm"></h3>
                </div>
                <div class="item-action mb-2 ml-2">
                    <Link class="form-confirm text-sm" :href="route('items.show', { item: item.id })">
                        View
                    </Link>
                </div>
            </div>
        </div>

        <PaginationComponent :pages="props.items.links" />
    </section>

</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { route } from 'ziggy-js';
import { Link, useForm } from '@inertiajs/vue3';
import PaginationComponent from '../../components/PaginationComponent.vue';
import utils from './../../util/utils.js'

const props = defineProps({
    items: Object,
    categories: Array
})

const filteringData = useForm({
    categories: [],
    county: null,
    sector: null
})

const filtering_visible = ref(false)
const toggleFiltersVisible = () => {
    resetFilters()
    filtering_visible.value = !filtering_visible.value
}

const storeSelectedCategories = (ev) => {
    const category_exists = filteringData.categories.includes(ev.target.value)

    if (category_exists) {
        const index_to_remove = filteringData.categories.indexOf(ev.target.value)
        filteringData.categories.splice(index_to_remove, 1)
    } else {
        filteringData.categories.push(ev.target.value)
    }
}

const applyFilters = () => {
    console.log(filteringData);
}

const resetFilters = () => {
    filteringData.categories = []
    filteringData.county = null
    filteringData.sector = null
}

watch(filteringData, (newV) => {
    if(newV.county !== 'Bucuresti') {
        filteringData.sector = null
    }
})

</script>

<style scoped>

input.filter-checkbox[type=checkbox]:checked + span.selected-checkbox {
    position: absolute;
    inset: 0;
    background-color: #62748e;
    padding: 0;
    margin: 0;
    z-index: -1;
}

</style>

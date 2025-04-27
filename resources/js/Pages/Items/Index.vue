<template>

    <section class="items flex flex-col gap-3 px-2">

        <div class="items-filters">
            <form @submit.prevent="applyFilters">
                <div class="form-control"></div>
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

import { route } from 'ziggy-js';
import { Link } from '@inertiajs/vue3';
import PaginationComponent from '../../components/PaginationComponent.vue';

const props = defineProps({
    items: Object,
    categories: Array
})

const applyFilters = () => {
    console.log('todo');
}

</script>

<template>
    <section class="profile-items flex flex-col px-4">

        <h2 class="text-slate-300 font-bold text-xl mb-4">My items</h2>

        <div class="profile-items-main flex flex-col gap-2 mb-4">
            <div v-for="item in props.items.data" :key="item.id" class="item flex border-1 rounded-md border-slate-500 overflow-hidden">
                <div class="item-image flex items-center w-50 text-teal-50 bg-gray-300">
                    <img v-if="item.photos && item.photos.length" class="object-cover w-full h-full mx-auto" :src="item.photos[0].url" />
                    <img v-else class="object-contain w-full h-auto mx-auto" src="../../../assets/placeholder.png" />
                </div>
                <div class="item-main w-150 p-2">
                    <div class="item-description mb-4">
                        <h3 v-html="item.name" class="text-white font-bold"></h3>
                        <small v-if="item.deleted_at" class="text-slate-300">Deleted at: {{ deletedAt(item.deleted_at) }}</small>
                    </div>

                    <div class="item-actions flex gap-2" v-if="item.deleted_at">
                        <Link :href="route('profile.items.restore', { item: item.id })" method="PUT" as="button" 
                            class="px-2 bg-orange-200 text-slate-700 rounded mt-2 text-sm">
                                restore
                        </Link>
                    </div>
                    <div class="item-actions flex gap-2" v-else>
                        <template v-if="item.sold_at">
                            <Link :href="route('profile.items.show', { item: item.id })" as="button" 
                                class="px-2 bg-slate-200 text-slate-700 rounded mt-2 text-sm">
                                    view exchange details
                            </Link>
                            <p class="ml-auto px-2 py-1 border-1 border-green-900 rounded-sm bg-green-600 text-green-900 text-sm">OFFER ACCEPTED</p>
                        </template>

                        <template v-else>
                            <Link :href="route('profile.items.show', { item: item.id })" as="button" 
                                class="px-2 bg-slate-200 text-slate-700 rounded mt-2 text-sm">
                                    offers ({{ item.offers.length }})
                            </Link>
                            <Link :href="route('profile.items.edit', { item: item.id })" as="button"
                                class="px-2 bg-sky-200 text-sky-700 rounded mt-2 text-sm">
                                    edit
                            </Link>
                            <Link :href="route('profile.items.destroy', { item: item.id })" method="DELETE" as="button" 
                                class="px-2 bg-red-200 text-red-700 rounded mt-2 text-sm">
                                    delete
                            </Link>
                        </template>
                    </div>
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
    items: Object
})

const deletedAt = (date) => {
    let deleted_at = new Date(date)
    return deleted_at.toLocaleString()
}
</script>

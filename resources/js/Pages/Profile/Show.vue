<template>
    <section class="profile-item-section">
        <div class="profile-item-header flex justify-between mb-4 px-4">
            <h2 class="text-slate-100 font-bold">Preview item</h2>
            <button @click.prevent="goBack" class="form-confirm">
                Back
            </button>
        </div>

        <template v-if="props.item.offers.length">
            <div class="offers px-4 mb-8">
                <div class="offer-header mb-4">
                    <h2 class="text-slate-100 font-bold">Offers</h2>
                    <p v-if="props.item.offers.length > 1" class="text-xs mt-4 bg-yellow-500 text-yellow-800 rounded-xl px-4 py-2">Caution! Once an offer is accepted, the rest of the offers will be automatically rejected.</p>
                </div>
        
                <div v-for="offer in props.item.offers" :key="offer.id" class="offer-box flex justify-between items-end mb-4 text-slate-100 py-1.5 px-4 border-1 border-slate-100 rounded-xl">
                    <div class="offer-box-details">
                        <small>{{ util.formatDate(offer.created_at) }}</small>
                        <h3>{{ offer.name }}</h3>
                        <p>{{ offer.user.name }}</p>
                    </div>
                    <div class="offer-box-actions flex gap-2">
                        <template v-if="offer.accepted_at || offer.rejected_at">
                            <p v-if="offer.accepted_at" class="px-2 py-1 border-1 border-green-900 rounded-sm bg-green-600 text-green-900 text-sm">OFFER ACCEPTED</p>
                            <p v-else class="px-2 py-1 border-1 border-red-900 rounded-sm bg-red-600 text-red-900 text-sm">OFFER REJECTED</p>
                        </template>
                        <Link v-else 
                              :href="route('profile.offer.accept', { offer: offer.id })" 
                              method="PUT" as="button" 
                              class="text-green-200">
                                Accept offer
                        </Link>
                    </div>
                </div>

            </div>
        </template>

        <div class="profile-item-user flex justify-between mb-2 px-4" v-if="props.item.user">
            <p class="text-slate-300 text-sm">posted by {{ props.item.user.name }}</p>
            <p class="text-slate-300 text-xs">{{ util.formatDate(props.item.created_at) }}</p>
        </div>

        <div class="show-item-main flex flex-col items-center justify-center gap-2 px-4">
            <div class="item-image w-full h-fit text-teal-50">
                <template v-if="hasImages">
                    <img class="object-contain w-full h-auto mx-auto" :src="props.item.photos[0].url" />
                </template>
                <template v-else>
                    <img class="object-contain w-full h-auto mx-auto" src="../../../assets/placeholder.png" />
                </template>
            </div>
            <div class="item-main w-full p-2">
                <h3 v-html="props.item.name" class="text-white mb-4"></h3>
                <p v-html="props.item.description" class="text-white text-xs"></p>

                <div class="profile-item-address text-slate-100 text-xs mt-4" v-if="props.item.address">
                    <p>City: {{ props.item.address.city }}</p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { computed } from 'vue'
import util from './../../util/utils.js'

const props = defineProps({
    item: Object
})

const hasImages = computed(() => props.item.photos && props.item.photos.length)
const goBack = () => window.history.back()

</script>

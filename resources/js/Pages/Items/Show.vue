<template>
    <section class="show-item">
        <div class="item-back mb-4 px-4">
            <button @click.prevent="goBack" class="form-confirm">
                Back
            </button>
        </div>

        <div class="profile-item-user flex justify-between mb-2 px-4" v-if="props.item.user">
            <p class="text-slate-300 text-sm">posted by {{ props.item.user.name }}</p>
            <p class="text-slate-300 text-xs">{{ createdAt }}</p>
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
                    <p>County: {{ props.item.address.county }}</p>
                    <p v-if="props.item.address.county === 'Bucuresti'">Sector: {{ props.item.address.sector }}</p>
                </div>
            </div>
        </div>

        <div class="item-bidding px-4 text-white my-8">
            <div class="item-bidding-offer flex flex-col" v-if="props.item.offers.length">
                <h3 class="text-sm font-bold mb-2">All offers:</h3>
                
                <div class="item-offered p-4 rounded-sm border-1 border-slate-100" v-for="offer in props.item.offers">
                    <p>
                        {{ offer.name }}
                    </p>
                </div>
            </div>

            <div class="item-bidding-offer mt-4" v-if="isAuth && !isOwn && !alreadyOffered">
                <form @submit.prevent="makeOffer" method="post">
                    <div class="form-control flex flex-col">
                        <label for="offer">Make an offer</label>
                        <select v-model="offer.offered_item_id" name="offer" id="offer" class="bg-white text-slate-500 text-sm mt-2 p-1">
                            <option value="#" selected>Choose from your stock</option>
                            <option 
                                v-for="offer in props.availableUserItems" 
                                :key="offer.id" 
                                :value="offer.id">
                                    {{ offer.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-control">
                        <button type="submit" class="form-confirm mt-4">Bid now</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script setup>
import { route } from 'ziggy-js';
import { computed, watch } from 'vue';
import { Link, usePage, useForm } from '@inertiajs/vue3';

const page = usePage();
const isAuth = computed(() => page.props.user)

const props = defineProps({
    item: Object,
    availableUserItems: Array
})

const offer = useForm({
    item_id: props.item.id || null,
    name: null,
    offered_item_id: null
})

watch(offer, (newV) => {
    if (newV) {
        const selected_item = props.availableUserItems.find(item => item.id === offer.offered_item_id)
        if (selected_item) {
            offer.name = selected_item.name
        }
    }
})

const makeOffer = () => {
    offer.post(route('items.offer.store', { item: offer.item_id }))
}

const isOwn = computed(() => props.item.user_id === page.props.user.id)
const alreadyOffered = computed(() => props.item.offers.find(item => item.user_id === page.props.user.id))

const createdAt = computed(() => {
    let created_at = new Date(props.item.created_at)
    return created_at.toLocaleString()
})

const hasImages = computed(() => props.item.photos && props.item.photos.length)
const goBack = () => window.history.back()

</script>

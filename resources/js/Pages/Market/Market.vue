<template>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gray-900 text-white">
        <h1 class="text-3xl font-bold mb-6">Market</h1>
        <div class="flex flex-col gap-4">
            <div v-for="offer in offers" :key="offer.id" class="rounded-lg p-4 border-2 border bg-clip-border" :class="{'border-pulse border-4 bg-cyan-900': offer.promoted}">
                <h2 class="text-xl text-center font-bold mb-2 font-mono" :class="{'text-orange-500': offer.promoted}">{{ offer.promoted ? 'Promoted' : '' }} Offer by {{offer.user.name}}</h2>
                <p>Status {{ offer.status }}</p>
                <p>Created at {{ parseDate(offer.created_at) }}</p>
                <p>Expires at {{ parseDate(offer.expires_at) }}</p>
                <ul class="grid grid-cols-2">
                    <li v-for="item in offer.items" class="py-2 text-center">
                        <p class="text-gray-300 italic">{{ item.cosmetic.name }}</p>
                    </li>
                </ul>
                <div class="flex justify-between mt-4">
                    <button
                        v-if="usePage().props.auth?.user"
                        :disabled="isUserOffer(offer)"
                        class="px-4 py-2 border border-sky-600 rounded hover:bg-sky-700 transition-all duration-150"
                        :class="{'cursor-not-allowed hover:bg-transparent': isUserOffer(offer)}">
                        {{ isUserOffer(offer) ? 'Your offer' : 'Request trade' }}
                    </button>
                    <button @click="cancelOffer(offer)" v-if="isUserOffer(offer)" class="px-4 py-2 border border-amber-900 rounded hover:bg-amber-800 transition-all duration-150">Cancel Offer</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import {Link, router, usePage} from "@inertiajs/vue3";
import {onMounted} from "vue";
import moment from "moment";

const props = defineProps({
    offers: Array,
})

const parseDate = (date) => {
    return moment(date).format('DD-MM-YYYY HH:mm')
}

const isUserOffer = (offer) => {
    return usePage().props.auth?.user?.id === offer.user.id
}

const cancelOffer = (offer) => {
    router.delete('/market/' + offer.id)
}

</script>

<style scoped>
.border-pulse {
    border-color: #0f4c75;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        border-color: cyan;
    }

    70% {
        border-color: rgba(15, 76, 117, 0);
    }

    100% {
        border-color: cyan;
    }
}
</style>

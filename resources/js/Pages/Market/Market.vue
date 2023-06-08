<template>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gray-900 text-white">
        <h1 class="text-3xl font-bold mb-6">Market</h1>
        <div class="flex flex-col gap-4">
            <div v-for="offer in offers" :key="offer.id"
                 class="rounded-lg p-4 border-2 border bg-clip-border shadow-lg w-full"
                 :class="{'border-pulse border-4 bg-cyan-900': offer.promoted}">
                <h2 class="text-xl text-center font-bold mb-2 font-mono" :class="{'text-orange-500': offer.promoted}">
                    {{ offer.promoted ? 'Promoted' : '' }} Offer by {{ offer.user.name }}</h2>
                <div class="flex flex-col mt-2">
                    <p class="font-semibold">AT price: {{ offer.at_price }}</p>
                    <p class="font-semibold">LAT price: {{ offer.lat_price }}</p>
                </div>
                <p class="mt-4 text-gray-300">{{ offer.description }}</p>
                <div class="grid grid-cols-2 gap-2 mt-4">
                    <div v-for="item in offer.items" class="py-2 px-2 bg-gray-800 rounded text-center">
                        <p class="text-gray-300 italic">{{ item.cosmetic.name }}</p>
                    </div>
                </div>
                <div class="mr-auto mt-2">
                    <p class="text-sm text-gray-400">Created at: {{ parseDate(offer.created_at) }}</p>
                    <p class="text-sm text-gray-400">Expires at: {{ parseDate(offer.expires_at) }}</p>
                </div>
                <div class="flex justify-between mt-6">
                    <button
                        v-if="usePage().props.auth?.user"
                        :disabled="isUserOffer(offer)"
                        class="w-full sm:w-auto px-4 py-2 bg-sky-600 rounded hover:bg-sky-700 transition-all duration-150"
                        :class="{'cursor-not-allowed bg-gray-600': isUserOffer(offer)}">
                        {{ isUserOffer(offer) ? 'Your offer' : 'Request trade' }}
                    </button>
                    <button @click="cancelOffer(offer)" v-if="isUserOffer(offer)"
                            class="w-full sm:w-auto mt-2 sm:mt-0 sm:ml-2 px-4 py-2 bg-amber-900 rounded hover:bg-amber-800 transition-all duration-150">
                        Cancel Offer
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {router, usePage} from "@inertiajs/vue3";
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

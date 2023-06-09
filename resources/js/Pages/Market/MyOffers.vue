<template>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gray-900 text-white">
        <h1 class="text-3xl font-bold mb-6">Your offers</h1>

        <div class="flex flex-col gap-4">
            <div v-for="offer in offers.data" :key="offer.id"
                 class="rounded-lg p-4 border-2 border bg-clip-border shadow-lg w-full"
                 :class="{'border-pulse border-4 bg-cyan-900': offer.promoted}">
                <div class="flex flex-col mt-2">
                    <p class="font-semibold">AT price: {{ offer.at_price }}</p>
                    <p class="font-semibold">LAT price: {{ offer.lat_price }}</p>
                </div>
                <p class="mt-4 text-gray-300">{{ offer.description }}</p>
                <div class="grid grid-cols-2 gap-2 mt-4">
                    <div v-for="item in offer.items" class="py-2 px-2 bg-gray-800 rounded text-center">
                        <p class="text-gray-300 italic">{{ item.amount }}x {{ item.cosmetic.name }}</p>
                    </div>
                </div>
                <div class="mr-auto mt-2">
                    <p class="text-sm text-gray-400">Created at: {{ parseDate(offer.created_at) }}</p>
                    <p class="text-sm text-gray-400">Expires at: {{ parseDate(offer.expires_at) }}</p>
                </div>
                <div class="flex justify-between mt-6">
                    <button @click="cancelOffer(offer)"
                            class="w-full sm:w-auto mt-2 sm:mt-0 sm:ml-2 px-4 py-2 bg-amber-900 rounded hover:bg-amber-800 transition-all duration-150">
                        Cancel Offer
                    </button>
                </div>
            </div>
        </div>
        <div class="flex justify-between my-4">
            <button @click="previousPage"
                    :disabled="!props.offers.prev_page_url"
                    :class="{'cursor-not-allowed bg-gray-600 !hover:bg-gray-700': !props.offers.prev_page_url}"
                    class="px-4 py-2 bg-blue-700 rounded transition-all duration-150"
            >Previous Page
            </button>
            <button @click="nextPage"
                    :disabled="!props.offers.next_page_url"
                    :class="{'cursor-not-allowed bg-gray-600 !hover:bg-gray-700': !props.offers.next_page_url}"
                    class="px-4 py-2 bg-blue-700 rounded transition-all duration-150"
            >Next Page
            </button>
        </div>
    </div>
</template>

<script setup>
import {router} from "@inertiajs/vue3";
import moment from "moment";
import {onMounted, ref} from "vue";
import Toast from "@/Utility/Toast.js";

let page = ref(1);

const props = defineProps({
    offers: Object,
})

onMounted(() => {
    console.log(props.offers)
})

const nextPage = () => {
    if (props.offers.next_page_url) {
        router.get(props.offers.next_page_url)
    }
}

const previousPage = () => {
    if (props.offers.prev_page_url) {
        router.get(props.offers.prev_page_url)
    }
}

const parseDate = (date) => {
    return moment(date).format('DD-MM-YYYY HH:mm')
}

const cancelOffer = (offer) => {
    router.delete('/market/' + offer.id, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            Toast.fire({
                icon: 'success',
                title: 'Offer canceled successfully'
            })
        }
    })
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

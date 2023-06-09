<template>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gray-900 text-white">
        <h1 class="text-3xl font-bold mb-6">Market</h1>

        <div class="bg-gray-800 p-4 rounded-lg mb-8">
            <h2 class="text-2xl font-semibold mb-4">Filters</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <label for="userFilter" class="block text-sm font-medium text-gray-400">User:</label>
                    <select id="userFilter" v-model="filters.seller"
                            class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
                        <option value="">All</option>
                        <option v-for="seller in sellers" :key="seller.id" :value="seller.id">{{ seller.name }}</option>
                    </select>
                </div>
                <div>
                    <label for="priceFilter" class="block text-sm font-medium text-gray-400">Max LAT Price:</label>
                    <input type="number" id="priceFilter" v-model="filters.lat_price" @keyup.enter="applyFilters"
                           class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
                </div>
                <div>
                    <label for="priceFilter" class="block text-sm font-medium text-gray-400">Max AT Price:</label>
                    <input type="number" id="priceFilter" v-model="filters.at_price" @keyup.enter="applyFilters"
                           class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
                </div>
                <div>
                    <label for="itemFilter" class="block text-sm font-medium text-gray-400">Item:</label>
                    <input type="text" id="itemFilter" v-model="filters.item" @keyup.enter="applyFilters"
                           class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
                </div>
            </div>
            <button @click="applyFilters"
                    class="w-full sm:w-auto px-4 py-2 bg-indigo-700 rounded-md hover:bg-indigo-600 transition-all duration-150 text-white font-semibold">
                Apply Filters
            </button>
        </div>

        <div class="flex flex-col gap-4">
            <div v-for="offer in offers.data" :key="offer.id"
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
                        <p class="text-gray-300 italic">{{ item.amount }}x {{ item.cosmetic.name }}</p>
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
import {router, usePage} from "@inertiajs/vue3";
import moment from "moment";
import {onMounted, ref} from "vue";

let page = ref(1);
let filters = ref({seller: '', at_price: '', lat_price: '', item: ''});

const props = defineProps({
    offers: Object,
    sellers: Object,
})

onMounted(() => {

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

const applyFilters = () => {
    let params = {
        page: 1,
        filter: {},
    }
    if (filters.value.seller) {
        params.filter.seller = filters.value.seller
    }
    if (filters.value.at_price) {
        params.filter.at_price = filters.value.at_price
    }
    if (filters.value.lat_price) {
        params.filter.lat_price = filters.value.lat_price
    }
    if (filters.value.item) {
        params.filter.item = filters.value.item
    }

    router.get('/market', params, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}

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

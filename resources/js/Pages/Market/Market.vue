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
                        <p class="text-gray-300 italic">{{ item.amount }}x {{ item.item.name }}</p>
                    </div>
                </div>
                <div class="mr-auto mt-2">
                    <p class="text-sm text-gray-400">Created at: {{ parseDate(offer.created_at) }}</p>
                    <p class="text-sm text-gray-400">Expires at: {{ parseDate(offer.expires_at) }}</p>
                </div>
                <div class="flex justify-between mt-6">
                    <button
                        @click="openModalWithOffer(offer)"
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
            <button v-if="usePage().props.offers.prev_page_url"
                    @click="previousPage"
                    :disabled="!props.offers.prev_page_url"
                    :class="{'cursor-not-allowed bg-gray-600 !hover:bg-gray-700': !props.offers.prev_page_url}"
                    class="px-4 py-2 bg-blue-700 rounded transition-all duration-150"
            >Previous Page
            </button>
            <button v-if="usePage().props.offers.next_page_url"
                    @click="nextPage"
                    :disabled="!props.offers.next_page_url"
                    :class="{'cursor-not-allowed bg-gray-600 !hover:bg-gray-700': !props.offers.next_page_url}"
                    class="px-4 py-2 bg-blue-700 rounded transition-all duration-150"
            >Next Page
            </button>
        </div>
    </div>

    <Modal :open="modalOpen" @close="closeModal">
        <div v-if="selectedOffer">
            <h3 class="text-xl font-bold">Offer Details:</h3>
            <p>AT Price: {{ selectedOffer.at_price }}</p>
            <p>LAT Price: {{ selectedOffer.lat_price }}</p>

            <form class="flex flex-col space-y-4" @submit.prevent="submitTradeRequest">
                <div>
                    <label for="latPrice" class="block text-sm font-medium text-gray-400">Your LAT Price:</label>
                    <input id="latPrice" v-model="tradeRequest.lat_price" type="number" required
                           class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
                </div>

                <div>
                    <label for="atPrice" class="block text-sm font-medium text-gray-400">Your AT Price:</label>
                    <input id="atPrice" v-model="tradeRequest.at_price" type="number" required
                           class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-400">Message:</label>
                    <textarea id="message" v-model="tradeRequest.message" rows="3"
                              class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white"></textarea>
                </div>

                <p class="block text-sm font-medium text-gray-400">Items:</p>
                <div v-for="item in selectedOffer.items" :key="item.id" class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" :id="'item-' + item.id" v-model="tradeRequest.items" :value="item.id">
                        <label :for="'item-' + item.id" class="ml-2">{{ item.item.name }}</label>
                    </div>
                    <input type="number" v-model="tradeRequest.itemAmounts[item.id]" class="w-20 bg-indigo-500" :min="1" :max="item.amount">
                </div>

                <button type="submit"
                        class="w-full px-4 py-2 bg-indigo-700 rounded-md hover:bg-indigo-600 transition-all duration-150 text-white font-semibold">
                    Submit Trade Request
                </button>
            </form>

        </div>
    </Modal>
</template>

<script setup>
import {router, usePage} from "@inertiajs/vue3";
import moment from "moment";
import {computed, onMounted, ref} from "vue";
import Modal from "@/Components/Modal.vue";
import {useToast} from "vue-toastification";

let page = ref(1);
let filters = ref({seller: '', at_price: '', lat_price: '', item: ''});

const modalOpen = ref(false);
const selectedOffer = ref(null);

const tradeRequest = ref({
    lat_price: '',
    at_price: '',
    message: '',
    items: [],
    itemAmounts: {},
})

const formattedItems = computed(() => {
    return tradeRequest.value.items.map(item => {
        return {
            id: item,
            amount: tradeRequest.value.itemAmounts[item]
        };
    });
});

const submitTradeRequest = () => {
    const requestData = {
        lat_price: tradeRequest.value.lat_price,
        at_price: tradeRequest.value.at_price,
        message: tradeRequest.value.message,
        items: formattedItems.value,
    };

    router.post('market/' + selectedOffer.value.id + '/buy', requestData, {
        preserveScroll: true,
        onSuccess: (message) => {
            useToast().success('Trade request sent!');
            closeModal();
        },
        onError: (errors) => {
            useToast().error(errors.error);
        }
    });
}

const openModalWithOffer = (offer) => {
    selectedOffer.value = offer;

    tradeRequest.value.items = offer.items.map(item => item.id);
    tradeRequest.value.itemAmounts = offer.items.reduce((amounts, item) => {
        amounts[item.id] = item.amount;
        return amounts;
    }, {});
    tradeRequest.value.lat_price = offer.lat_price;
    tradeRequest.value.at_price = offer.at_price;

    modalOpen.value = true;
}


const closeModal = () => {
    modalOpen.value = false;
    selectedOffer.value = null;
}

const props = defineProps({
    offers: Object,
    sellers: Object,
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

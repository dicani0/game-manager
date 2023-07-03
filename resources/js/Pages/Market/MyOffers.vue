<template>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gray-900 text-white">
        <h1 class="text-3xl font-bold mb-6">Your offers</h1>

        <div class="flex flex-col gap-4">

            <div v-for="offer in offers.data" :key="offer.id"
                 class="relative rounded-lg p-4 border-2 border bg-clip-border shadow-lg w-full"
                 :class="{'border-pulse border-4 bg-cyan-900': offer.promoted}">
                <Transition>
                    <div>
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
                            <button @click="cancelOffer(offer)"
                                    class="w-full sm:w-auto mt-2 sm:mt-0 sm:ml-2 px-4 py-2 bg-amber-900 rounded hover:bg-amber-800 transition-all duration-150">
                                Cancel Offer
                            </button>
                        </div>


                        <button v-if="offer.offers.length > 0" @click="toggleTradeRequests(offer.id)"
                                class="flex items-center justify-center w-8 h-8 bg-sky-900 rounded-full border transition-all duration-150 absolute bottom-0 mb-[-20px] left-2/4 ml-[-16px]">
                            <vue-feather
                                :type="shownTradeRequests.includes(offer.id) ? 'chevrons-up' : 'chevrons-down'"></vue-feather>
                        </button>

                        <Transition>
                            <div v-show="shownTradeRequests.includes(offer.id)">
                                <div v-for="request in offer.offers" :key="request.id"
                                     class="bg-transparent border p-4 rounded-lg my-2">
                                    <h2 class="text-xl font-bold">Request by {{ request.creator.name }}</h2>
                                    <div class="flex flex-col md:flex-row justify-between mt-2">
                                        <div class="flex flex-col">
                                            <p class="font-semibold">AT price: {{ request.at_price }}</p>
                                            <p class="font-semibold">LAT price: {{ request.lat_price }}</p>
                                        </div>
                                        <p>Status: <span class="font-semibold text-green-500">{{ request.status }}</span></p>
                                    </div>
                                    <p class="mt-2">{{ request.message }}</p>
                                    <ul>
                                        <li v-for="item in request.items">{{ item.name }}</li>
                                    </ul>
                                    <div class="mt-4 flex justify-between">
                                        <button @click="acceptRequest(offer, request)"
                                                class="w-full sm:w-auto mt-2 sm:mt-0 sm:ml-2 px-4 py-2 bg-green-900 rounded hover:bg-green-800 transition-all duration-150">
                                            Accept Request
                                        </button>
                                        <button @click="rejectRequest(offer, request)"
                                                class="w-full sm:w-auto mt-2 sm:mt-0 sm:ml-2 px-4 py-2 bg-red-900 rounded hover:bg-red-800 transition-all duration-150">
                                            Decline Request
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </Transition>
                    </div>
                </Transition>

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
import {ref} from "vue";
import Toast from "@/Utility/Toast.js";
import {useToast} from "vue-toastification";

let page = ref(1);

const props = defineProps({
    offers: Object,
})

let shownTradeRequests = ref([]);

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

const cancelOffer = async (offer) => {
    const result = await Toast.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
    });

    if (!result.isConfirmed) {
        return;
    }

    router.delete('/market/' + offer.id, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            useToast().success('Offer cancelled');
        },
        onError: (error) => {
            console.log(error);
            useToast().error('Something went wrong');
        }
    })
}

const toggleTradeRequests = (offerId) => {
    const index = shownTradeRequests.value.indexOf(offerId);
    if (index === -1) {
        shownTradeRequests.value.push(offerId);
    } else {
        shownTradeRequests.value.splice(index, 1);
    }
};

const acceptRequest = async (offer, request) => {
    const result = await Toast.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
    });

    if (!result.isConfirmed) {
        return;
    }

    router.post('/market/' + offer.id + '/' + request.id + '/accept', null, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            useToast().success('Request accepted successfully')
        },
        onError: () => {
            useToast().error('Something went wrong')
        }
    })
}

const rejectRequest = async (offer, request) => {
    const result = await Toast.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
    });

    if (!result.isConfirmed) {
        return;
    }

    router.post('/market/' + offer.id + '/' + request.id + '/reject', {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            Toast.fire({
                icon: 'success',
                title: 'Request rejected successfully'
            })
        }
    })
}


</script>

<style scoped>
.v-enter-active,
.v-leave-active {
    transition: all .3s ease;
}

.v-enter-from,
.v-leave-to {
    height: 100%;
    opacity: 0;
    transform: translateX(10px);
}

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

<template>
    <div class="container mx-auto px-4 py-8">
        <ul class="space-y-6">
            <li v-for="request in props.requests.data" :key="request.id" class="bg-gray-800 rounded-lg p-4 shadow-lg">
                <div class="grid grid-cols-3 gap-4">
                    <p class="text-lg font-semibold text-white">Request type: {{ request.type }}</p>
                    <p class="text-lg font-semibold text-white text-center">
                        LAT: {{ request.lat_price }} | AT: {{ request.at_price }}
                    </p>
                    <p class="text-lg font-semibold text-white text-right">Type: {{ request.offer_type }}</p>
                </div>

                <div class="mt-2">
                    <p class="text-white">From: {{ request.user.name }}</p>
                    <p class="text-gray-400">Status: {{ request.status }}</p>
                    <p class="text-gray-400">Message: {{ request.message }}</p>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                            @click="acceptOffer(request.id)">
                        Accept
                    </button>
                    <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                            @click="rejectOffer(request.id)">
                        Reject
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {router, usePage} from "@inertiajs/vue3";
import moment from "moment";
import {onMounted, ref} from "vue";
import Toast from "@/Utility/Toast.js";
import {useToast} from "vue-toastification";
import {MarketOfferStatusEnum} from "@/Enums/MarketOfferStatusEnum.ts";

const props = defineProps({
    requests: Object,
})

const acceptOffer = (id) => {
}

const rejectOffer = (id) => {
}

</script>

<template>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gray-900 text-white">
        <h1 class="text-3xl font-bold mb-6">Market</h1>
        <div class="flex flex-col gap-4">
            <div v-for="offer in offers" :key="offer.id" class="rounded-lg p-4 border-2 border bg-clip-border" :class="{'border-pulse border-4 bg-cyan-900': offer.promoted}">
                <h2 class="text-xl text-center font-bold mb-2" :class="{'text-orange-500': offer.promoted}">{{ offer.promoted ? 'Promoted' : '' }} Offer by {{offer.user.name}}</h2>
                <p>Created at {{ parseDate(offer.created_at) }}</p>
                <p>Expires at {{ parseDate(offer.expires_at) }}</p>
                <ul class="grid grid-cols-2">
                    <li v-for="item in offer.items" class="py-2 text-center">
                        <p class="text-gray-300">{{ item.cosmetic.name }}</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import {Link} from "@inertiajs/vue3";
import {onMounted} from "vue";
import moment from "moment";

const props = defineProps({
    offers: Array,
})

onMounted(() => {
    console.log(props.offers)
})

const parseDate = (date) => {
    return moment(date).format('DD-MM-YYYY HH:mm')
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

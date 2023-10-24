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

        <ul>
          <li v-for="item in request.items">
            <p><span class="font-bold">{{ item.name }}</span> - <span class="italic">{{ item.amount }}</span></p>
          </li>
        </ul>

        <div v-if="request.status === 'Pending'" class="mt-4 flex justify-end space-x-2">
          <button class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                  @click="acceptRequest(request.offerable, request)">
            Accept
          </button>
          <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                  @click="rejectRequest(request.offerable, request)">
            Reject
          </button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>

import Toast from "@/Utility/Toast.js";
import {router} from "@inertiajs/vue3";

const props = defineProps({
  requests: Object,
})

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

  router.post('/market/' + request.id + '/' + offer.id + '/accept', null, {
    preserveScroll: true,
    preserveState: true,
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

  router.post('/market/' + request.id + '/' + offer.id + '/reject', {
    preserveScroll: true,
    preserveState: true,
  })
}

</script>

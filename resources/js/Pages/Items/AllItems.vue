<template>
  <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-gray-200 mb-6">All items list</h1>
    <div class="mb-6">
      <label class="block text-gray-300 text-sm font-bold mb-2" for="search">Search by name:</label>
      <input
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          id="search"
          type="text"
          v-model="search">
    </div>
    <ul class="grid grid-cols-10 gap-1">
      <li v-for="item in filteredItems" :key="item.id" class="p-4 bg-gray-800 rounded shadow-md text-gray-200">
        <p :class="{'text-green-300': item.obtained, 'text-red-600': !item.obtained}" class="text-sm font-medium">
          {{ item.name }}</p>
        <!--        <p class="text-xs">Usable amount: {{ item.usable_amount }}</p>-->
        <p v-if="user" :class="{'text-green-800': item.usable_amount <= item.obtained_amount}" class="text-xs">Your
          amount: {{ item.obtained_amount ?? 0 }}</p>
      </li>
    </ul>
  </div>
</template>

<script setup>
import {usePage} from "@inertiajs/vue3";
import {computed, ref, toRefs} from "vue";

const props = defineProps({
  items: {
    type: Array,
    default: () => []
  },
});

const {items} = toRefs(props);

let search = ref('');

const user = usePage().props.auth.user;

let filteredItems = computed(() => {
  return items.value.filter(item => item.name.toLowerCase().includes(search.value.toLowerCase()));
});
</script>
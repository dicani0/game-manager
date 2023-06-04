<template>
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-gray-200 mb-6">Cosmetics list</h1>
        <div class="mb-6">
            <label class="block text-gray-300 text-sm font-bold mb-2" for="search">Search by name:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                   id="search"
                   type="text"
                   v-model="search">
        </div>
        <ul class="grid grid-cols-6 gap-1">
            <li v-for="cosmetic in filteredCosmetics" :key="cosmetic.id" class="p-4 bg-gray-800 rounded shadow-md text-gray-200">
                <p :class="{'text-green-800': cosmetic.obtained, 'text-red-600': !cosmetic.obtained}" class="text-sm font-medium">{{ cosmetic.name }}</p>
                <p class="text-xs">Usable amount: {{ cosmetic.usable_amount }}</p>
                <p :class="{'text-green-800': cosmetic.usable_amount <= cosmetic.obtained_amount}" class="text-xs">Your amount: {{ cosmetic.obtained_amount ?? 0 }}</p>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {ref, computed, toRefs} from 'vue';

const props = defineProps({
    cosmetics: {
        type: Array,
        default: () => []
    },
});

const { cosmetics } = toRefs(props);

let search = ref('');

let filteredCosmetics = computed(() => {
    return cosmetics.value.filter(cosmetic => cosmetic.name.toLowerCase().includes(search.value.toLowerCase()));
});
</script>



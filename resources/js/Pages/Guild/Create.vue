<template>
  <div v-if="props.characters.length > 0" class="w-full max-w-xs mx-auto my-20">
    <form @submit.prevent="create" class="bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
      <div class="mb-4">
        <label class="block text-gray-300 text-sm font-bold mb-2" for="name">
          Name
        </label>
        <input
            class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
            id="name" type="text" v-model="form.name" required autofocus>
      </div>
      <div class="mb-4">
        <label class="block text-gray-300 text-sm font-bold mb-2" for="character">
          Character
        </label>
        <select
            class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
            id="character" v-model="form.leader_id" required>
          <option v-for="character in characters" :key="character.id" :value="character.id">
            {{ character.name }}
          </option>
        </select>
      </div>
      <div class="flex items-center justify-between">
        <button
            :disabled="form.processing"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
          Create
        </button>
      </div>
    </form>
  </div>
  <div v-else class="text-center p-4">
    <p class="text-3xl text-red-700">You don't have a character to create the guild!</p>
  </div>
</template>

<script setup lang="ts">
import {router} from '@inertiajs/vue3';
import {reactive} from "vue";

interface Character {
  id: number;
  name: string;
}

const props = defineProps({
  characters: Object as () => Character[],
})

const form = reactive({
  name: null,
  leader_id: null,
  processing: false,
});

const create = () => {
  router.post('/guilds', form);
}
</script>

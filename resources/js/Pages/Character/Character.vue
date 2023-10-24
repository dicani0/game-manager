<template>
  <div class="max-w-7xl py-4 mx-auto sm:px-6 lg:px-8 bg-gray-800 text-white">
    <div class="flex justify-between items-center mt-6">
      <h1 class="text-3xl font-semibold text-white">Your Characters</h1>
      <Link href="/characters/create"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Create Character
      </Link>
    </div>
    <div v-if="characters.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
      <div class="p-6 bg-gray-700 rounded-lg shadow flex flex-col items-center" v-for="character in characters"
           :key="character.id">
        <h2 class="text-2xl font-semibold text-white">{{ character.name }}</h2>
        <p class="text-lg text-gray-300">{{ character.vocation }}</p>
        <p v-if="character.guild">{{ character.guild.name }}</p>
        <p v-else>No guild</p>
        <div class="flex gap-2">
          <button
              class="mt-4 bg-teal-400 hover:bg-teal-900 text-white font-bold py-2 px-4 rounded flex items-center"
              @click="editCharacter(character.id)">
            <vue-feather type="x-circle" class="mr-2"></vue-feather>
            Edit
          </button>
          <button
              class="mt-4 bg-red-500 hover:bg-red-900 text-white font-bold py-2 px-4 rounded flex items-center"
              @click="deleteCharacter(character.id)">
            <vue-feather type="x-circle" class="mr-2"></vue-feather>
            Delete
          </button>
        </div>
      </div>
    </div>
    <div v-else class="mt-6">
      <p class="text-xl text-gray-400 text-center">You don't have any characters yet.</p>
    </div>
  </div>
</template>

<script setup>
import {Link, router} from "@inertiajs/vue3";
import Toast from "@/Utility/Toast.js";

const props = defineProps({
  characters: Array,
})

const deleteCharacter = async (id) => {
  const result = await Toast.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    confirmButtonText: 'Yes, delete it!'
  })

  if (result.isConfirmed) {
    router.delete(`/characters/${id}`)
  }
}
const editCharacter = (id) => {
  router.get(`/characters/edit/${id}`);
}
</script>

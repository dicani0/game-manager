<template>
  <div class="container mx-auto px-4 py-8 bg-gray-900 text-white">
    <div class="p-6 bg-gray-800 rounded-lg shadow-md">
      <div class="flex flex-row justify-between items-center p-2">
        <h1 class="text-2xl font-bold mr-4">{{ guild.name }}</h1>
        <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
                @click="openEditModal = true">Edit
        </button>
      </div>
      <div>
        <span>Recruiting:</span>
        <div v-if="guild.recruiting">
          <vue-feather class="mr-2 text-green-500" type="check"></vue-feather>
        </div>
        <div v-else>
          <vue-feather class="mr-2 text-red-500" type="x"></vue-feather>
        </div>
      </div>
      <div class="mb-4">
        <h2 class="text-xl font-semibold mb-2">Members</h2>
        <ul class="list-disc list-inside text-gray-300">
          <li v-for="member in guild.characters" :key="member.id">
            {{ member.nickname }}
            {{ member.vocation }}
            {{ member.role }}
          </li>
        </ul>
      </div>
    </div>
  </div>

  <Modal :open="openEditModal" :width="'w-1/6'" class="transition-all" @close="openEditModal = false">
    <form class="flex flex-col items-center w-full text-center p-4" @submit.prevent="updateGuild">
      <div class="mb-4 w-full">
        <h2 class="text-xl mb-4">Edit your guild</h2>
        <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Name</label>
        <input
            id="name"
            v-model="form.name"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            required
            type="text">
        <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Description</label>
        <textarea
            id="description"
            v-model="form.description"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            required>
          {{ form.description }}
        </textarea>
        <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Recruiting</label>
        <input
            id="recruiting"
            class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            required
            :checked="form.recruiting"
            type="checkbox">
      </div>
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-2/6"
              type="submit">Update
      </button>

    </form>
  </Modal>
</template>

<script setup lang="ts">
import {defineProps, ref} from 'vue';
import Modal from "@/Components/Modal.vue";

interface Member {
  id: number;
  name: string;
  nickname: string;
  vocation: string
  role: string
}

interface Guild {
  id: number;
  name: string;
  recruiting: boolean;
  description: string;
  characters: Member[];
}

const props = defineProps<{
  guild: Guild;
}>()

const form = ref(
    {
      name: props.guild.name,
      recruiting: props.guild.recruiting,
      description: props.guild.description,
    }
)

const openEditModal = ref(false)

const updateGuild = () => {
  console.log(form)
}

</script>

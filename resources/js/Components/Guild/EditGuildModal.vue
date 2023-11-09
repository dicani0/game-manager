<template>
  <Modal :open="open" :width="'w-1/6'" class="transition-all" @close="closeModal">
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
        >
          {{ form.description }}
        </textarea>

        <label class="block text-gray-300 text-sm font-bold mb-2" for="leader">Leader</label>
        <select id="leader" v-model="form.leader_id" class="w-full text-black" name="leader">
          <option v-for="character in guild.characters" :value="character.id">{{ character.nickname }}</option>
        </select>
        <label class="block text-gray-300 text-sm font-bold mb-2" for="recruiting">Recruiting</label>
        <input
            id="recruiting"
            :checked="form.recruiting"
            class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="checkbox"
            @change="form.recruiting = !form.recruiting">
      </div>
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-2/6"
              type="submit">Update
      </button>

    </form>
  </Modal>
</template>

<script lang="ts" setup>
import {defineEmits, defineProps, ref} from 'vue';
import Modal from "@/Components/Modal.vue";
import {Guild} from "@/types/Guild";


const props = defineProps<{
  open: boolean;
  guild: Guild;
}>();

const emit = defineEmits(['update', 'closeEditModal']);

const form = ref({
  name: props.guild.name,
  recruiting: props.guild.recruiting,
  leader_id: props.guild.characters.filter(character => character.role === 'leader')[0].id,
  description: props.guild.description,
});

const closeModal = () => {
  emit('closeEditModal', false);
}

const updateGuild = () => {
  emit('update', form.value);
};
</script>

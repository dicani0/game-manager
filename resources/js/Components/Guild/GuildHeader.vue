<template>
  <div class="flex flex-row justify-between items-center bg-gray-800 p-4 rounded-lg shadow">
    <h1 class="text-3xl font-bold text-white mr-4">{{ guild.name }}</h1>
    <div class="flex gap-3">
      <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition duration-200"
              @click="onEdit">Edit
      </button>
      <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-200"
              @click="$emit('invite')">Invite
      </button>
    </div>
  </div>
</template>

<script lang="ts" setup>
import {defineEmits, defineProps} from 'vue';
import {Guild} from "@/types/Guild";

const props = defineProps<{
  guild: Guild;
}>();

const emit = defineEmits(['edit', 'invite']);

const onEdit = () => emit('edit');
</script>
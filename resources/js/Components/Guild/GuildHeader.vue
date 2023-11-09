<template>
  <div class="flex flex-row justify-between items-center">
    <h1 class="text-2xl font-bold mr-4">{{ guild.name }}</h1>
    <div class="flex gap-2">
      <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
              @click="$emit('edit')">Edit
      </button>
      <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
              @click="$emit('invite')">Invite
      </button>
    </div>
  </div>
</template>

<script lang="ts" setup>
import {defineEmits, defineProps} from 'vue';

const props = defineProps<{
  guild: { name: string };
}>();

const emit = defineEmits(['edit', 'invite']);

const onEdit = () => emit('edit');
</script>
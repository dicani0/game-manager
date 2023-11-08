<template>
  <div class="flex flex-row justify-between items-center">
    <h1 class="text-2xl font-bold mr-4">{{ guild.name }}</h1>
    <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded"
            @click="$emit('edit')">Edit
    </button>
  </div>
</template>

<script setup lang="ts">
import { defineProps, defineEmits } from 'vue';

const props = defineProps<{
  guild: { name: string };
}>();

const emit = defineEmits(['edit']);

const onEdit = () => emit('edit');
</script>
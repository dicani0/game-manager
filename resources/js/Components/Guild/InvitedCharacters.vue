<template>
  <div class="bg-gray-700 shadow-md overflow-hidden mt-2">
    <div class="bg-gray-800 py-2">
      <h3 class="text-white text-lg font-semibold">Invitations</h3>
    </div>
    <ul class="divide-y divide-gray-600">
      <li v-for="invitation in invitations" :key="invitation.id"
          class="p-4 hover:bg-gray-500 transition duration-150 ease-in-out flex justify-between items-center">
        <span class="font-medium text-gray-900">{{ invitation.character.name }}</span>
        <span class="ml-4 text-sm text-gray-300">{{ invitation.character.vocation }}</span>
      </li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
import {defineProps} from 'vue';
import {Invitation} from "@/types/Guild";

const props = defineProps<{ invitations: Invitation[] }>();
</script>

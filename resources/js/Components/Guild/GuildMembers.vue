<template>
  <div class="bg-gray-700 p-4 rounded-lg shadow-lg mt-2">
    <h2 class="text-xl font-semibold text-white mb-3">Members</h2>
    <ul class="space-y-2">
      <li v-for="member in members" :key="member.id"
          class="flex justify-between items-center bg-gray-800 p-3 rounded-lg">
        <div>
          <div class="text-white font-medium">{{ member.nickname }}</div>
          <div class="text-sm text-gray-400">{{ member.vocation }} - {{ member.role }}</div>
        </div>
        <button v-if="member.role !== 'leader' && (permissions.is_leader || permissions.is_vice_leader) "
                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition duration-200"
                @click="kick(member.id)">
          Kick
        </button>
      </li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
import {defineProps} from 'vue';

interface Member {
  id: number;
  nickname: string;
  vocation: string;
  role: string;
}

const props = defineProps<{
  members: Member[];
  permissions: {
    is_leader: boolean;
    is_vice_leader: boolean;
  }
}>();

const emit = defineEmits(['kick']);
const kick = (memberId: number) => {
  emit('kick', memberId);
};
</script>
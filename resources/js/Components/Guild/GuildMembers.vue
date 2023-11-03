<template>
  <div class="bg-gray-700 p-4 rounded-lg">
    <h2 class="text-xl font-semibold mb-2">Members</h2>
    <ul>
      <li v-for="member in members" :key="member.id" class="flex justify-between items-center p-2 bg-gray-600 rounded-lg mb-2">
        <div>
          <div>{{ member.nickname }}</div>
          <div class="text-sm text-gray-400">{{ member.vocation }} - {{ member.role }}</div>
        </div>
        <button v-if="member.role !== 'Leader'" @click="kick(member.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
          Kick
        </button>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from 'vue';

interface Member {
  id: number;
  nickname: string;
  vocation: string;
  role: string;
}

const props = defineProps<{ members: Member[] }>();

const emit = defineEmits(['kick']);
const kick = (memberId: number) => {
  emit('kick', memberId);
};
</script>
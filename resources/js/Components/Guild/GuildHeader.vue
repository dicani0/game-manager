<template>
  <div class="flex flex-row justify-between items-center bg-gray-800 p-4 rounded-lg shadow">
    <h1 class="text-3xl font-bold text-white mr-4">{{ guild.name }}</h1>
    <div class="flex gap-3">
      <button v-if="can['edit']"
              class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition duration-200"
              @click="onEdit">Edit
      </button>
      <button v-if="can['invite']"
              class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-200"
              @click="$emit('invite')">Invite
      </button>
      <Link class="bg-violet-500 hover:bg-violet-600 text-white font-bold py-2 px-4 rounded transition duration-200"
            :href="`/guilds/${guild.id}/polls`">
        Polls
      </Link>
    </div>
  </div>
</template>

<script lang="ts" setup>
import {defineEmits, defineProps} from 'vue';
import {Guild} from "@/types/Guild";
import {Link} from '@inertiajs/vue3';

const props = defineProps<{
  guild: Guild;
  can: string[];
}>();

const emit = defineEmits(['edit', 'invite']);

const onEdit = () => emit('edit');
</script>
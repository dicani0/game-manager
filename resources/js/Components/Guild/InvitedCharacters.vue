<template>
  <div class="bg-gray-700 shadow-md overflow-hidden mt-2">
    <div class="bg-gray-800 py-2">
      <h3 class="text-white text-lg font-semibold">Invitations</h3>
    </div>
    <ul class="divide-y divide-gray-600">
      <li v-for="invitation in invitations" :key="invitation.id"
          class="p-4 hover:bg-gray-500 transition duration-150 ease-in-out flex justify-between items-center">
        <div>
          <span class="font-medium text-gray-900">{{ invitation.character.name }}</span>
          <span class="ml-4 text-sm text-gray-300">{{ invitation.character.vocation }}</span>
        </div>
        <button class="bg-red-700 hover:bg-red-900 text-white font-bold py-1 px-2 rounded transition duration-200"
                @click="cancelInvitation(invitation.id)">Cancel
        </button>
      </li>
    </ul>
  </div>
</template>

<script lang="ts" setup>
import {defineProps} from 'vue';
import {Invitation} from "@/types/Guild";
import {router} from "@inertiajs/vue3";

const props = defineProps<{ invitations: Invitation[] }>();

const cancelInvitation = (invitationId: number) => {
  router.post(`/guilds/invites/${invitationId}/cancel`)
};
</script>

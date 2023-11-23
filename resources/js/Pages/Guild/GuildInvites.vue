<template>
  <div class="flex justify-center">
    <ul class="max-w-6xl w-full bg-gray-700 rounded-lg shadow-lg">
      <li v-for="invitation in invites" :key="invitation.id" class="border-b border-gray-600 last:border-b-0">
        <div class="flex justify-between items-center p-4 hover:bg-gray-600 transition-colors duration-150 ease-in-out">
          <div>
            <p>{{ invitation.guild.name }}</p>
            <p>{{ invitation.character.name }}</p>
          </div>
          <div>
            <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 mr-2"
                    @click="acceptInvitation(invitation.id)">Accept
            </button>
            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                    @click="rejectInvitation(invitation.id)">Reject
            </button>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>


<script lang="ts" setup>
import {defineProps} from 'vue';
import {GuildInvitation} from "@/types/Guild";
import {router} from "@inertiajs/vue3";

const props = defineProps<{
  invites: GuildInvitation[]
}>();

const acceptInvitation = (id: number) => {
  router.post(`/guilds/invites/${id}/accept`);
};

const rejectInvitation = (id: number) => {
  router.post(`/guilds/invites/${id}/reject`);
};
</script>

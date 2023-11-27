<template>
  <div class="container mx-auto px-4 py-8 bg-gray-800 rounded-xl text-white">
    <GuildHeader :can="can" :guild="guild" @edit="openEditModal = true" @invite="openInviteModal = true"/>
    <RecruitmentStatus :recruiting="props.guild.recruiting"/>
    <GuildMembers :members="guild.characters" :permissions="permissions" @kick="kickMember"/>
    <EditGuildModal :guild="guild" :open.sync="openEditModal" @closeEditModal="openEditModal = false"
                    @update="updateGuild"/>
    <InviteToGuildModal :characters="props.characters" :guild="guild" :open.sync="openInviteModal"
                        @closeInviteModal="openInviteModal = false" @invited="reload"/>
    <InvitedCharacters :canCancel="can['cancel-invitation']" :invitations="props.guild.invitations"/>
  </div>
</template>

<script lang="ts" setup>
import {ref} from 'vue';
import {router} from "@inertiajs/vue3";
import GuildHeader from "@/Components/Guild/GuildHeader.vue";
import RecruitmentStatus from "@/Components/Guild/RecruitmentStatus.vue";
import GuildMembers from "@/Components/Guild/GuildMembers.vue";
import EditGuildModal from "@/Components/Guild/EditGuildModal.vue";
import {CharactersPagination, Guild} from "@/types/Guild";
import InviteToGuildModal from "@/Components/Guild/InviteToGuildModal.vue";
import InvitedCharacters from "@/Components/Guild/InvitedCharacters.vue";

const props = defineProps<{
  guild: Guild;
  characters: CharactersPagination;
  invitations: any;
  can: string[];
}>();

const permissions = {
  is_leader: props.guild.is_leader,
  is_vice_leader: props.guild.is_vice_leader
};

const openEditModal = ref(false);
const openInviteModal = ref(false);
const updateGuild = (formData: any) => {
  router.patch(`/guilds/${props.guild.id}`, formData, {
    onSuccess: () => {
      openEditModal.value = false;
    }
  });
};

const reload = (page: number) => {
  router.reload({only: ['characters'], data: {page: page}});
};

const kickMember = (memberId: number) => {
  router.delete(`/guilds/${props.guild.id}/kick/${memberId}`);
};
</script>

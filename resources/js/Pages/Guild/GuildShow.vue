<template>
  <div class="container mx-auto px-4 py-8 bg-gray-800 rounded-xl text-white">
    <GuildHeader :guild="guild" @edit="openEditModal = true" />
    <RecruitmentStatus :recruiting="props.guild.recruiting" />
    <GuildMembers :members="guild.characters" @kick="kickMember" />
    <EditGuildModal :open.sync="openEditModal" :guild="guild" @update="updateGuild" @close="openEditModal = false" />
  </div>
</template>

<script setup lang="ts">
import {ref} from 'vue';
import { router } from "@inertiajs/vue3";
import GuildHeader from "@/Components/Guild/GuildHeader.vue";
import RecruitmentStatus from "@/Components/Guild/RecruitmentStatus.vue";
import GuildMembers from "@/Components/Guild/GuildMembers.vue";
import EditGuildModal from "@/Components/Guild/EditGuildModal.vue";
import {Guild} from "@/types/Guild";


const props = defineProps<{
  guild: Guild;
}>();

const openEditModal = ref(false);
const updateGuild = (formData: any) => {
  router.patch(`/guilds/${props.guild.id}`, formData, {
    onSuccess: () => {
      openEditModal.value = false;
    }
  });
};

const kickMember = (memberId: number) => {
  router.delete(`/guilds/${props.guild.name}/kick/${memberId}`);
};
</script>

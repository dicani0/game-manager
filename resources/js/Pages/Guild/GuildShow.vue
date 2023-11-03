<template>
  <div class="container mx-auto px-4 py-8 bg-gray-800 rounded-xl text-white">
    <GuildHeader :guild="guild" @edit="openEditModal = true" />
    <RecruitmentStatus :recruiting="guild.recruiting" />
    <GuildMembers :members="guild.characters" />
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

interface Member {
  id: number;
  name: string;
  nickname: string;
  vocation: string;
  role: string;
}

interface Guild {
  id: number;
  name: string;
  recruiting: boolean;
  description: string;
  characters: Member[];
}

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
  //TODO: implement
  console.log(`Kick member with id: ${memberId}`);
};
</script>


<script setup lang="ts">
import {ref} from 'vue';
import { router } from "@inertiajs/vue3";
import GuildHeader from "@/Components/Guild/GuildHeader.vue";
import RecruitmentStatus from "@/Components/Guild/RecruitmentStatus.vue";
import GuildMembers from "@/Components/Guild/GuildMembers.vue";
import EditGuildModal from "@/Components/Guild/EditGuildModal.vue";

interface Member {
  id: number;
  name: string;
  nickname: string;
  vocation: string;
  role: string;
}

interface Guild {
  id: number;
  name: string;
  recruiting: boolean;
  description: string;
  characters: Member[];
}

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
</script>

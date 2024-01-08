<template>
  <CreatePollForm :pollable_id="guild.id" :pollable_type="'App\\Models\\Guild\\Guild'"></CreatePollForm>
</template>

<script setup lang="ts">
import {defineProps} from 'vue';
import CreatePollForm from "@/Pages/Poll/CreatePollForm.vue";
import {Guild} from "@/types/Guild";

const props = defineProps<{
  guild: Guild
}>();

</script>

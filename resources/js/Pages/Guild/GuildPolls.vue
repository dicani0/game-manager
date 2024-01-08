<template>
  <Polls :can="can" :header="'Guild polls'" :create-link="'polls/create'" :polls="polls"></Polls>
</template>

<script setup lang="ts">
import Polls from "@/Pages/Poll/Polls.vue";
import {defineProps, onMounted} from 'vue';

onMounted(() => {
  console.log();
});

defineProps<{
  polls: any;
  can: any;
}>();
</script>

<template>
  <div>
    <h1>Global Polls</h1>
  </div>
</template>

<script setup lang="ts">
import {PollPagination} from "@/types/Poll";

defineProps<{
  polls: PollPagination;
}>();
</script>
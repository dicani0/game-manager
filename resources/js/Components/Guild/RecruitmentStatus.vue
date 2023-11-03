<template>
  <div>
    <span>Recruiting:</span>
    <vue-feather :class="iconClass" :type="iconType"></vue-feather>
  </div>
</template>

<script setup lang="ts">
import { defineProps, computed } from 'vue';

const props = defineProps<{ recruiting: boolean }>();

const iconClass = computed(() => props.recruiting ? 'mr-2 text-green-500' : 'mr-2 text-red-500');
const iconType = computed(() => props.recruiting ? 'check' : 'x');
</script>
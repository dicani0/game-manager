<template>
  <div class="flex items-center mt-2">
    <span class="text-white mr-2">Recruiting:</span>
    <vue-feather :class="iconClass" :type="iconType"></vue-feather>
  </div>
</template>

<script lang="ts" setup>
import {computed, defineProps} from 'vue';

const props = defineProps<{ recruiting: boolean }>();

const iconClass = computed(() => props.recruiting ? 'mr-2 text-green-500' : 'mr-2 text-red-500');
const iconType = computed(() => props.recruiting ? 'check' : 'x');

</script>
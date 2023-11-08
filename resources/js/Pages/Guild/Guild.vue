<template>
  <div class="container mx-auto px-4 py-8">
    <ul class="space-y-4">
      <li v-for="guild in guilds.data" :key="guild.id"
          class="flex p-4 border rounded-lg bg-gray-900 shadow">
        <Link :href="`/guilds/${guild.name}`" class="text-blue-500 hover:text-blue-700 hover:underline">
          {{ guild.name }}
          Recruiting {{ guild.recruiting ? 'Yes' : 'No' }}
        </Link>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import {defineProps} from 'vue';
import {Link} from '@inertiajs/vue3';

interface Guild {
  id: number;
  name: string;
  recruiting: boolean;
}

interface GuildData {
  data: Guild[];
}

const props = defineProps({
  guilds: Object as () => GuildData,
})

</script>
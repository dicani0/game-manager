<template>
  <div class="container mx-auto px-4 py-8">
    <ul class="space-y-4">
      <Link v-for="guild in guilds.data" :key="guild.id" :href="`/guilds/${guild.name}`"
            class="flex items-center p-4 border border-gray-700 rounded-lg bg-gray-900 shadow-lg transition duration-300 ease-in-out hover:bg-gray-800">
        <div class="flex-grow">
          <h2 class="text-xl font-semibold text-blue-400 hover:text-blue-300">
            {{ guild.name }}
          </h2>
          <p class="text-gray-300 text-sm mt-2">
            Recruiting: <span
              :class="guild.recruiting ? 'text-green-400' : 'text-red-400'">{{ guild.recruiting ? 'Yes' : 'No' }}</span>
          </p>
        </div>
      </Link>
    </ul>
  </div>
</template>


<script lang="ts" setup>
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
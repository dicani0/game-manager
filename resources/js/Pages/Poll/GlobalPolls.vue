<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex items-center gap-2">
      <h1 class="text-2xl font-bold">Global Polls</h1>
      <Link href="/polls/create"
            class="px-2 py-1 font-bold text-white bg-green-500 rounded hover:bg-green-700 transition duration-300">
        +
      </Link>
    </div>
    <div class="rounded-lg">
      <ul>
        <li v-for="poll in polls.data" :key="poll.id" class="py-2 rounded-lg">
          <Link :href="`/polls/${poll.id}`"
                class="flex justify-between items-center p-4 m-1 hover:shadow-xl shadow-md transition duration-300 hover:bg-gray-600 shadow-gray-700 border border-gray-400 bg-gray-800 rounded-lg">
            <div class="flex gap-8 items-center">
              <p class="text-lg font-medium">{{ poll.title }}</p>
              <p class="italic">{{ poll.description }}</p>
            </div>
            <Link :href="`polls/${poll.id}/edit`"
                  class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 transition duration-300">
              Edit
            </Link>
          </Link>

        </li>
      </ul>
    </div>

    <!-- Pagination -->
    <div class="flex justify-between items-center my-4">
      <Link :href="polls.prev_page_url" v-if="polls.prev_page_url"
            class="py-2 px-4 text-white bg-blue-500 rounded hover:bg-blue-700 transition duration-300">
        Previous
      </Link>
      <span v-if="polls.data.length > polls.total">Page {{ polls.current_page }} of {{ polls.last_page }}</span>
      <Link :href="polls.next_page_url" v-if="polls.next_page_url"
            class="py-2 px-4 text-white bg-blue-500 rounded hover:bg-blue-700 transition duration-300">
        Next
      </Link>
    </div>
  </div>
</template>

<script setup lang="ts">
import {PollPagination} from "@/types/Poll";
import {Link} from "@inertiajs/vue3";

const props = defineProps<{
  polls: PollPagination;
}>();
</script>

<style>
/* Optionally, add custom styles or include your Tailwind CSS here */
</style>

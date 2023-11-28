<template>
  <div class="container mx-auto bg-gray-900 text-white z-10">
    <ul class="divide-y divide-gray-700">
      <li v-for="notification in all_notifications.data" :key="notification.id"
          class="px-4 py-2 hover:bg-gray-700 transition duration-150 ease-in-out cursor-pointer">
        {{ notification.data.message }}
        <Link v-if="notification.data.link" class="cursor-pointer text-bold text-cyan-700"
              :href="`/notifications/${notification.id}/read`">Check here
        </Link>
      </li>
    </ul>

    <div class="flex justify-between items-center p-4">
      <button @click="goToPage(all_notifications.prev_page_url)"
              :disabled="!all_notifications.prev_page_url"
              class="px-3 py-1 bg-teal-500 text-white rounded-md hover:bg-teal-600 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150">
        Previous
      </button>
      <span>Page {{ all_notifications.current_page }} of {{ all_notifications.last_page }}</span>
      <button @click="goToPage(all_notifications.next_page_url)"
              :disabled="!all_notifications.next_page_url"
              class="px-3 py-1 bg-teal-500 text-white rounded-md hover:bg-teal-600 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150">
        Next
      </button>
    </div>
  </div>
</template>

<script lang="ts" setup>
import {NotificationsPagination} from "@/types/Notification";
import {defineProps} from "vue";
import {Link, router} from "@inertiajs/vue3";

const props = defineProps<{
  all_notifications: NotificationsPagination;
}>();

const goToPage = (url: string | null) => {
  router.visit(url ?? '');
};
</script>
<template>
  <div class="bg-gray-900 text-white w-50 z-10">
    <ul class="divide-y divide-gray-700">
      <li v-for="notification in notifications.data" :key="notification.id"
          class="px-4 py-2 hover:bg-gray-700 transition duration-150 ease-in-out cursor-pointer">
        {{ notification.data.message }}
        <!-- Additional notification details -->
      </li>
    </ul>

    <div class="pagination flex justify-between items-center p-4">
      <button @click="goToPage(notifications.prev_page_url)"
              :disabled="!notifications.prev_page_url"
              class="px-3 py-1 bg-teal-500 text-white rounded-md hover:bg-teal-600 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150">
        Previous
      </button>
      <span>Page {{ notifications.current_page }} of {{ notifications.last_page }}</span>
      <button @click="goToPage(notifications.next_page_url)"
              :disabled="!notifications.next_page_url"
              class="px-3 py-1 bg-teal-500 text-white rounded-md hover:bg-teal-600 disabled:opacity-50 disabled:cursor-not-allowed transition ease-in-out duration-150">
        Next
      </button>
    </div>
  </div>
</template>

<script lang="ts" setup>
import {NotificationsPagination} from "@/types/Notification";
import {defineProps, onMounted} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps<{
  notifications: NotificationsPagination;
}>();

onMounted(() => {
  console.log(props.notifications);
});

const goToPage = (url: string | null) => {
  router.visit(url ?? '');
};
</script>

<style scoped>
.notifications-list {
  /* Styles for your notifications list */
}

.pagination {
  /* Styles for pagination controls */
}
</style>
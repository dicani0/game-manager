<template>
    <!-- Wrapper -->
    <div class="overflow-hidden w-100 flex flex-col items-center">
        <!-- User List -->
        <ul class="space-y-4 p-4 bg-gray-800 rounded-lg shadow-lg w-1/3">
            <li v-for="user in props.users.data" :key="user.id" class="border-b border-gray-700 pb-4">
                <p class="text-xl text-gray-300 font-semibold mb-2">{{ user.name }}</p>
                <p class="text-sm text-gray-400 mb-4">{{ user.discord_name }}</p>

                <!-- Toggle Items Button -->
                <button class="text-blue-400 text-sm mb-2" @click="user.showItems = !user.showItems">
                    {{ user.showItems ? 'Hide Items' : 'Show Items' }}
                </button>

                <!-- User's Items -->
                <Transition name="slide-fade">
                    <ul v-show="user.showItems" key="item-list"
                        class="expand-fade-enter-active expand-fade-leave-active ml-4">
                        <li v-for="item in user.items" class="mb-2">
                            <p class="text-md text-gray-300">
                                {{ item.item_name }} | Power: {{ item.power }} | Tier: {{ item.tier }}
                            </p>
                            <ul class="ml-4">
                                <li v-for="attribute in item.attributes" class="text-sm text-gray-400">
                                    {{ attribute.name }}: +{{ attribute.value }}
                                </li>
                            </ul>
                        </li>
                        <button
                            class="text-blue-400 text-sm mb-2"
                            @click="openTradeModal(user)">
                            Request Trade
                        </button>
                    </ul>
                </Transition>
            </li>

        </ul>

        <!-- Pagination Controls -->
        <div class="flex justify-between my-4">
            <!-- Previous Page Button -->
            <button v-if="props.users.links.prev"
                    :class="{'cursor-not-allowed bg-gray-600 !hover:bg-gray-500': !props.users.links.prev}"
                    :disabled="!props.users.links.prev"
                    class="px-4 py-2 bg-gray-700 text-white rounded transition-all duration-150 hover:bg-gray-600"
                    @click="previousPage">
                Previous Page
            </button>

            <!-- Next Page Button -->
            <button v-if="props.users.links.next"
                    :class="{'cursor-not-allowed bg-gray-600 !hover:bg-gray-500': !props.users.links.next}"
                    :disabled="!props.users.links.next"
                    class="px-4 py-2 bg-gray-700 text-white rounded transition-all duration-150 hover:bg-gray-600"
                    @click="nextPage">
                Next Page
            </button>
        </div>
    </div>

    <Modal :open="modalOpen" @close="closeModal">
        <div v-if="selectedUser" class="max-h-screen overflow-y-auto p-4">
            <h3 class="text-xl font-bold">Offer Details:</h3>
            <form class="flex flex-col space-y-4" @submit.prevent="submitTradeRequest">
                <div>
                    <label class="block text-sm font-medium text-gray-400" for="latPrice">Your LAT Price:</label>
                    <input id="latPrice" v-model="tradeRequest.lat_price"
                           class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white"
                           required
                           type="number">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400" for="atPrice">Your AT Price:</label>
                    <input id="atPrice" v-model="tradeRequest.at_price"
                           class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white"
                           required
                           type="number">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400" for="message">Message:</label>
                    <textarea id="message" v-model="tradeRequest.message"
                              class="mt-1 block w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white"
                              rows="3"></textarea>
                </div>

                <p class="block text-sm font-medium text-gray-400">Items:</p>
                <div v-for="item in selectedUser.items" :key="item.id" class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input :id="'item-' + item.id" v-model="tradeRequest.items" :value="item.id" type="checkbox">
                        <label :for="'item-' + item.id" class="ml-2">{{ item.item_name }} (Available amount:
                            {{ item.available_amount }})</label>
                    </div>
                    <input v-model="tradeRequest.itemAmounts[item.id]" :max="item.available_amount" :min="1"
                           class="w-20 bg-indigo-500 text-white placeholder:text-white"
                           placeholder="0"
                           type="number">
                </div>

                <button
                    class="w-full px-4 py-2 bg-indigo-700 rounded-md hover:bg-indigo-600 transition-all duration-150 text-white font-semibold"
                    type="submit">
                    Submit Trade Request
                </button>
            </form>

        </div>
    </Modal>
</template>

<script setup>
// Importing required modules
import {router, usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import Modal from "@/Components/Modal.vue";

// Define component props
const props = defineProps({
    users: Object,
});

const modalOpen = ref(false);
const selectedUser = ref(null);

const tradeRequest = ref({
    lat_price: 0,
    at_price: 0,
    message: '',
    items: [],
    itemAmounts: {},
})

// Function to navigate to the next page
const nextPage = () => {
    if (props.users.next_page_url) {
        router.get(props.users.next_page_url);
    }
}

// Function to navigate to the previous page
const previousPage = () => {
    if (props.users.prev_page_url) {
        router.get(props.users.prev_page_url);
    }
}

const openTradeModal = (user) => {
    selectedUser.value = user;
    modalOpen.value = true;
}

const closeModal = () => {
    modalOpen.value = false;
}

const formattedItems = computed(() => {
    return tradeRequest.value.items.map(item => {
        return {
            id: item,
            amount: tradeRequest.value.itemAmounts[item]
        };
    });
});
const submitTradeRequest = () => {
    const requestData = {
        lat_price: tradeRequest.value.lat_price,
        at_price: tradeRequest.value.at_price,
        message: tradeRequest.value.message,
        items: formattedItems.value,
    };

    router.post('/market/user/' + selectedUser.value.id + '/buy', requestData, {
        preserveState: true,
        onSuccess: () => {
            closeModal();
        },
        onError: (error) => {
            console.log(error)
        }
    });
}
</script>

<style scoped>
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(-20px);
    opacity: 0;
}
</style>

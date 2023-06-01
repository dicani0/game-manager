<template>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-200">User's Items</h1>
            <button @click="openImportModal = true"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Import
            </button>
        </div>
        <ul class="grid grid-cols-4 text-xs">
            <li v-for="item in items" :key="item.name"
                class="p-4 flex flex-col justify-between items-start border hover:scale-125 hover:bg-cyan-900 transition-all">
                <div class="flex-grow">
                    <p></p>
                    <p class="text-lg font-medium text-gray-200 mb-2">{{ item.item_name }}</p>
                    <p class="text-gray-400">Amount: {{ item.amount }}</p>
                    <p :class="{ 'text-red-600': item.available_amount <= 0, 'text-green-600': item.available_amount > 0 }"
                       class="text-gray-400">
                        Available amount: {{ item.available_amount }}
                    </p>
                    <p class="text-gray-400">Sold amount: {{ item.sold_amount }}</p>
                    <p class="text-gray-400">Used amount: {{ item.used_amount }}</p>
                </div>
                <div class="flex gap-2">
                    <button @click="openUpdateModal(item)"
                            class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-1 px-2 rounded"
                            :class="{ '!bg-gray-500 !hover:bg-gray-500 cursor-not-allowed': item.available_amount <= 0}">
                        Sell
                    </button>
                    <button @click="openUpdateModal(item)"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Update
                    </button>
                    <button @click="deleteItem(item)"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete
                    </button>
                </div>
            </li>

        </ul>

        <Modal :open="openEditModal" @close="openEditModal = false" class="transition-all">
            <form @submit.prevent="updateAmount">
                <div class="mb-4 p-4">
                    <h2 class="text-xl mb-4">{{ selectedItem?.item_name }}</h2>
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="content">All amount</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        v-model="updateItemForm.amount"
                        type="number"
                        required
                        id="all_amount">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Sold amount</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        v-model="updateItemForm.sold_amount"
                        type="number"
                        required
                        id="sold_amount">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Used amount</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        v-model="updateItemForm.used_amount"
                        type="number"
                        required
                        id="used_amount">
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-1/2"
                        type="submit">Update
                </button>

            </form>
        </Modal>


        <Modal :open="openImportModal" @close="openImportModal = false">
            <form @submit.prevent="importItems">
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Copy paste your exclusives
                        list</label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        v-model="importForm.content"
                        required
                        rows="20"
                        id="content"></textarea>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full"
                        type="submit">Import
                </button>

            </form>
        </Modal>
    </div>
</template>

<script setup>
import {ref} from 'vue';
import Modal from "@/Components/Modal.vue";
import {useToast} from "vue-toastification";
import {useForm} from "@inertiajs/vue3";
import Toast from "@/Utility/Toast.js";

defineProps(['items']);

const importForm = useForm({
    content: '',
});

const updateItemForm = useForm({
    amount: null,
    sold_amount: null,
    used_amount: null,
});

let selectedItem = null;
let openImportModal = ref(false);
let openEditModal = ref(false);

const importItems = () => {
    importForm.post('/items/import', {
        onSuccess: (message) => {
            openImportModal.value = false;
            useToast().success(message.props.flash.success);
        },
        onError: (errors) => {
            Object.values(errors).forEach((error) => {
                useToast().error(error)
            });
        }
    });
};

const updateAmount = () => {
    updateItemForm.put(`/items/${selectedItem.id}`, {
        onSuccess: (message) => {
            openEditModal.value = false;
            useToast().success(message.props.flash.success);
        },
        onError: (errors) => {
            Object.values(errors).forEach((error) => {
                useToast().error(error)
            });
        }
    });
};

const openUpdateModal = (item) => {
    selectedItem = item;
    updateItemForm.amount = item.amount;
    updateItemForm.sold_amount = item.sold_amount;
    updateItemForm.used_amount = item.used_amount;

    openEditModal.value = true;
};

const deleteItem = async (item) => {
    const result = await Toast.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
    });
    if (result.isConfirmed) {
        updateItemForm.delete(`/items/${item.id}`, {
            onSuccess: (message) => {
                openEditModal.value = false;
                useToast().success(message.props.flash.success);
            },
            onError: (errors) => {
                Object.values(errors).forEach((error) => {
                    useToast().error(error)
                });
            }
        });
    }
};

</script>

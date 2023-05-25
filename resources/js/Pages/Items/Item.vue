<template>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-200">User's Items</h1>
            <button @click="openImportModal = true"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Import
            </button>
        </div>
        <ul class="grid grid-cols-4 text-sm">
            <li v-for="item in items" :key="item.name" class="p-4 flex justify-between items-center border">
                <div>
                    <p></p>
                    <p class="text-lg font-medium text-gray-200 mb-2">{{ item.item_name }}</p>
                    <p class="text-gray-400">Amount: {{ item.amount }}</p>
                    <div class="flex gap-2">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">Sell
                        </button>
                        <button @click="openEditModal = true" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Update
                        </button>
                    </div>
                </div>
            </li>
        </ul>

        <Modal :open="openEditModal" @close="openEditModal = false">
            <form @submit.prevent="register">
                <div class="mb-4">
                    <h2 class="text-xl mb-4">Edit item's data</h2>
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="content">All amount</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="number"
                        required
                        id="content">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Sold amount</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="number"
                        required
                        id="content">
                    <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Used amount</label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="number"
                        required
                        id="content">
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full"
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
                        v-model="form.content"
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

defineProps(['items']);

const form = useForm({
    content: '',
});

let openImportModal = ref(false);
let openEditModal = ref(false);

const importItems = () => {
    form.post('/items', {
        onSuccess: () => {
            openImportModal.value = false;
            useToast().success('Items imported successfully');
        },
        onError: (errors) => {
            Object.values(errors).forEach((error) => {
                useToast().error(error)
            });
        }
    });
};

</script>

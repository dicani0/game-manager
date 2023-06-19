<template>
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex">
        <div class="w-5/6 mr-4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-200">User's Items</h1>
                <button @click="openImportModal = true"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Import
                </button>
            </div>
            <ul class="grid grid-cols-5 gap-4 text-xs">
                <li v-for="item in items" :key="item.name"
                    class="p-4 flex flex-col justify-between items-start hover:scale-110 bg-gray-800 hover:bg-cyan-900 transition-all rounded-lg">
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
                        <p class="text-gray-400">Reserved amount: {{ item.reserved_amount }}</p>
                    </div>
                    <div class="flex gap-2">
                        <button @click="addItemToSale(item)"
                                :disabled="item.available_amount <= 0"
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

        </div>
        <div class="w-1/6 bg-gray-800 p-4 rounded shadow-lg border max-h-[85vh] overflow-y-auto">
            <h3 class="text-lg font-bold text-gray-200 mb-4">Create sale offer</h3>
            <Transition>
                <div v-if="selectedItemsForSale.length > 0">
                    <div class="flex items-center mb-4">
                        <div class="tooltip-container">
                            <input :disabled="usePage().props.auth.user.available_promotes < 1" type="checkbox" id="promote" class="form-checkbox bg-blue-700 h-5 w-5 text-blue-600" v-model="promote">
                            <label for="promote" class="ml-2 text-gray-300">Promote this offer(Available promotes: {{ usePage().props.auth.user.available_promotes }}).</label>
                            <div class="tooltip-text">
                                Warning: You won't get your promotion back if you cancel this offer.
                            </div>
                        </div>

                    </div>
                    <div class="mb-2">
                        <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Price in LATs</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            v-model.number="latPrice"/>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Price in ATs</label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            v-model.number="atPrice"/>
                    </div>
                    <div>
                        <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Description</label>
                        <textarea
                            rows="5"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            v-model="description"></textarea>
                    </div>
                </div>
            </Transition>

            <div class="flex">
                <button
                    @click="createMarketOffer"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 w-full mb-4"
                    :class="{ 'cursor-not-allowed bg-gray-900 hover:bg-gray-900': selectedItemsForSale.length === 0 }"
                    :disabled="selectedItemsForSale.length === 0">Create Offer
                </button>
                <button
                    @click="clearSaleItems"
                    class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 w-full mb-4"
                    :class="{ 'cursor-not-allowed !bg-gray-900 !hover:bg-gray-900': selectedItemsForSale.length === 0 }"
                    :disabled="selectedItemsForSale.length === 0">Clear
                </button>
            </div>
            <ul class="mb-4">
                <li v-for="item in selectedItemsForSale" :key="item.id" class="mb-2 flex items-center border-b pb-2">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center w-full">
                            <button @click="deleteItemFromSale(item)"
                                    class="bg-red-500 px-1 py-1 rounded inline-flex mr-2">
                                <vue-feather type="trash"></vue-feather>
                            </button>
                            <span>{{ item.item_name }}</span>
                        </div>
                        <input type="number" min="1" class="w-14 h-100 p-2 bg-gray-800 text-white rounded-xl"
                               v-model.number="item.sell_amount"/>
                    </div>
                </li>
            </ul>
        </div>

        <Modal :open="openEditModal" @close="openEditModal = false" :width="'w-1/6'" class="transition-all">
            <form class="flex flex-col items-center w-full text-center p-4" @submit.prevent="updateAmount">
                <div class="mb-4 w-full">
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
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-2/6"
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
import {router, useForm, usePage} from "@inertiajs/vue3";
import Toast from "@/Utility/Toast.js";

const props = defineProps(['items']);

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
let selectedItemsForSale = ref([]);
let promote = ref(false);
let latPrice = ref(0);
let atPrice = ref(0);
let description = ref('');

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

const addItemToSale = (item) => {
    if (!selectedItemsForSale.value.some(i => i.id === item.id)) {
        selectedItemsForSale.value.push({...item, sell_amount: 1});
    }
};

const deleteItemFromSale = (item) => {
    selectedItemsForSale.value = selectedItemsForSale.value.filter(i => i.id !== item.id);
};

const clearSaleItems = async (requiredConfirm = true) => {
    if (requiredConfirm) {
        const result = await Toast.fire({
            title: 'Are you sure?',
            icon: 'warning',
            confirmButtonText: 'Yes, clear the list!'
        })

        if (!result.isConfirmed) {
            return;
        }
    }

    selectedItemsForSale.value = [];
};

const createMarketOffer = async () => {
    const result = await Toast.fire({
        title: 'Are you sure?',
        icon: 'info',
        confirmButtonText: 'Yes, create offer!'
    })

    if (!result.isConfirmed) {
        return;
    }

    const items = selectedItemsForSale.value.map(i => {
        return {
            cosmetic_id: i.id,
            amount: i.sell_amount,
        }
    });

    router.post('/market',
        {
            items: items,
            promoted: promote.value,
            type: 'sell',
            description: description.value,
            at_price: atPrice.value,
            lat_price: latPrice.value,
        },
        {
            onSuccess: (message) => {
                useToast().success(message.props.flash.success);
                clearSaleItems(false);
            },
            onError: (errors) => {
                Object.values(errors).forEach((error) => {
                    useToast().error(error)
                });
            }
        })
};

</script>

<style scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.tooltip-container {
    position: relative;
    display: inline-block;
}

.tooltip-container .tooltip-text {
    visibility: hidden;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px;
    border-radius: 6px;
    position: absolute;
    z-index: 1;
    bottom: 100%; /* Position the tooltip above the text */
    left: 50%;
    margin-left: -60px; /* Use half of the width to center the tooltip */
    opacity: 0;
    transition: opacity 1s;
}

.tooltip-container:hover .tooltip-text {
    visibility: visible;
    opacity: 1;
}
</style>

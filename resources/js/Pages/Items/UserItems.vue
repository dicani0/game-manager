<template>
  <div class="px-4 sm:px-6 lg:px-8 py-12 flex box-border">
    <div class="w-5/6 mr-4">
      <h1 class="text-3xl flex-grow font-bold text-gray-200 text-center">Your items</h1>
      <div class="flex justify-between items-center mb-6 text-center">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                @click="openImportModal = true">Import
        </button>
      </div>
      <ul class="w-full grid sm:grid-cols-4 lg:grid-cols-5 gap-8 text-xs">
        <li v-for="item in items" :key="item.name"
            @mouseover="toggleTooltip(item, true)" @mouseleave="toggleTooltip(item, false)"
            class="p-4 flex flex-col justify-between items-start hover:scale-110 bg-gray-800 hover:bg-cyan-900 hover:z-50 transition-all rounded-lg relative group cursor-grab h-[200px] w-[calc(100%/5-gap)]">
          <p class="text-2xl font-medium text-gray-200 mb-2">{{ item.item_name }}</p>
          <div class="flex flex-row justify-between w-full">
            <div class="">
              <p></p>
              <p class="text-gray-400">Amount: {{ item.amount }}</p>
              <p :class="{ 'text-red-600': item.available_amount <= 0, 'text-green-600': item.available_amount > 0 }"
                 class="text-gray-400">
                Available amount: {{ item.available_amount }}
              </p>
              <p class="text-gray-400">Sold amount: {{ item.sold_amount }}</p>
              <p class="text-gray-400">Used amount: {{ item.used_amount }}</p>
              <p :class="{'text-purple-500': item.reserved_amount > 0}" class="text-gray-400">Reserved
                amount: {{ item.reserved_amount }}</p>
            </div>
            <div v-show="item.showTooltip" class="flex attributes-tooltip w-full h-full">
              <div>
                <div class="mb-4">
                  <p class="text-lg"><span>Tier: {{ item.tier }} Power: {{ item.power }}</span></p>
                </div>
                <p v-for="attribute in item.attributes" class="italic">
                  {{ attribute.name }}: {{ attribute.value }}
                </p>
              </div>
            </div>
          </div>
          <div class="flex gap-2">
            <button
                :class="{ '!bg-gray-500 !hover:bg-gray-500 cursor-not-allowed': item.available_amount <= 0}"
                :disabled="item.available_amount <= 0"
                class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-1 px-2 rounded"
                @click="addItemToSale(item)">
              Sell
            </button>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded"
                    @click="openUpdateModal(item)">Update
            </button>
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                    @click="deleteItem(item)">Delete
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
              <input id="promote" v-model="promote"
                     :disabled="usePage().props.auth.user.available_promotes < 1"
                     class="form-checkbox bg-blue-700 h-5 w-5 text-blue-600"
                     type="checkbox">
              <label class="ml-2 text-gray-300" for="promote">Promote(Available promotes:
                {{ usePage().props.auth.user.available_promotes }}).</label>
              <div class="tooltip-text">
                Warning: You won't get your promotion back if you cancel this offer.
              </div>
            </div>

          </div>
          <div class="mb-2">
            <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Price in LATs</label>
            <input
                v-model.number="latPrice"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
          </div>
          <div class="mb-4">
            <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Price in ATs</label>
            <input
                v-model.number="atPrice"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"/>
          </div>
          <div>
            <label class="block text-gray-300 text-sm font-bold mb-2 p-0" for="description">Description</label>
            <textarea
                v-model="description"
                class="shadow appearance-none w-full py-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                rows="5"></textarea>
          </div>
        </div>
      </Transition>

      <div class="flex">
        <button
            :class="{ 'cursor-not-allowed bg-gray-900 hover:bg-gray-900': selectedItemsForSale.length === 0 }"
            :disabled="selectedItemsForSale.length === 0"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 w-full mb-4"
            @click="createMarketOffer">Create Offer
        </button>
        <button
            :class="{ 'cursor-not-allowed !bg-gray-900 !hover:bg-gray-900': selectedItemsForSale.length === 0 }"
            :disabled="selectedItemsForSale.length === 0"
            class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 w-full mb-4"
            @click="clearSaleItems">Clear
        </button>
      </div>
      <ul class="mb-4">
        <li v-for="item in selectedItemsForSale" :key="item.id" class="mb-2 flex items-center border-b pb-2">
          <div class="flex items-center justify-between w-full">
            <div class="flex items-center w-full">
              <button class="bg-red-500 px-1 py-1 rounded inline-flex mr-2"
                      @click="deleteItemFromSale(item)">
                <vue-feather type="trash"></vue-feather>
              </button>
              <span>{{ item.item_name }}</span>
            </div>
            <input v-model.number="item.sell_amount"
                   class="w-14 h-100 p-2 bg-gray-800 text-white rounded-xl" min="1"
                   type="number"/>
          </div>
        </li>
      </ul>
    </div>

    <Modal :open="openEditModal" :width="'w-1/6'" class="transition-all" @close="openEditModal = false">
      <form class="flex flex-col items-center w-full text-center p-4" @submit.prevent="updateAmount">
        <div class="mb-4 w-full">
          <h2 class="text-xl mb-4">{{ selectedItem?.item_name }}</h2>
          <label class="block text-gray-300 text-sm font-bold mb-2" for="content">All amount</label>
          <input
              id="all_amount"
              v-model="updateItemForm.amount"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
              type="number">
          <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Sold amount</label>
          <input
              id="sold_amount"
              v-model="updateItemForm.sold_amount"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
              type="number">
          <label class="block text-gray-300 text-sm font-bold mb-2" for="content">Used amount</label>
          <input
              id="used_amount"
              v-model="updateItemForm.used_amount"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
              type="number">
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
              id="content"
              v-model="importForm.content"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
              rows="20"></textarea>
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
      item_id: i.id,
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
        onSuccess: () => {
          clearSaleItems(false);
        },
        onError: (errors) => {
          Object.values(errors).forEach((error) => {
            useToast().error(error)
          });
        }
      })
};

const toggleTooltip = (item, show) => {
  item.showTooltip = show;
};

</script>

<style scoped>


.group:hover .item-detail {
  visibility: visible;
  opacity: 1;
}

.attributes-tooltip {
  visibility: hidden;
  background-color: rgba(0, 0, 0, 0.8); /* semi-transparent background */
  color: #fff;
  padding: 5px;
  border-radius: 6px;
  position: absolute;
  z-index: 1;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  transition: visibility 0.3s, opacity 0.3s;
  opacity: 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

button {
  z-index: 2;
}

.group:hover .attributes-tooltip {
  visibility: visible;
  opacity: 1;
}
</style>

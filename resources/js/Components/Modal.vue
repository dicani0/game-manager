<template>
    <div v-if="open" class="fixed z-10 inset-0 overflow-y-auto w-1/2" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 flex items-center justify-center w-full">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>
            <div :class="width" class="bg-gray-900 rounded-lg text-white p-4 mx-auto relative">
                <button @click="closeModal" class="absolute right-4 top-4 text-gray-300">
                    X
                </button>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    open: Boolean,
    width: {
        type: String,
        default: 'w-2/6',
    },
});

const emit = defineEmits(['close']);
const closeModal = () => {
    emit('close');
};
</script>

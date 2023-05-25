<template>
    <div v-if="open" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-16 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>
            <div class="bg-gray-900 rounded-lg text-white p-4 max-w-md mx-auto mt-64 relative">
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
});

const emit = defineEmits(['close']);
const closeModal = () => {
    emit('close');
};
</script>

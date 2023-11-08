<template>
    <div v-if="open" aria-labelledby="modal-title" aria-modal="true"
         class="fixed z-10 inset-0 h-full overflow-y-auto w-1/2"
         role="dialog">
        <div class="fixed inset-0 flex items-center justify-center w-full">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>
            <div :class="width" class="bg-gray-900 rounded-lg text-white p-4 mx-auto relative">
                <button class="absolute right-4 top-4 text-gray-300" @click="closeModal">
                    X
                </button>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup>

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

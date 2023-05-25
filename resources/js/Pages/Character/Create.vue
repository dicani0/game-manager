<template>
    <div class="p-6 max-w-sm mx-auto bg-gray-800 text-white rounded-xl shadow-md flex items-center space-x-4">
        <div>
            <div class="text-xl font-medium text-white">Create Character</div>
            <p class="text-gray-500">Fill in the details for your new character.</p>

            <form @submit.prevent="create">
                <div class="mb-4">
                    <label class="block text-gray-500 text-sm font-bold mb-2" for="name">Character Name</label>
                    <input v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-500 text-sm font-bold mb-2" for="class">Class</label>
                    <select v-model="form.vocation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline" id="class" required>
                        <option v-for="vocation in vocations" :key="vocation" :value="vocation">
                            {{ vocation.charAt(0).toUpperCase() + vocation.slice(1) }}
                        </option>
                    </select>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" :disabled="form.processing">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>

import {useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import {onMounted} from "vue";

// Assuming vocations are passed as props
const props = defineProps({
    vocations: Array,
});

const form = useForm({
    name: '',
    vocation: '',
    level: 1,
});

onMounted(() => {
    console.log(props.vocations);
});

const create = () => {
    form.post('/characters', {
        onError: (errors) => {
            Object.values(errors).forEach((error) => {
                useToast().error(error);
            });
        },
        onSuccess: (response) => {
            console.log(response);
            useToast().success(response.props.success)
        },
    });
}

</script>

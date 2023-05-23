<template>
    <div class="w-full max-w-xs mx-auto my-20">
        <form @submit.prevent="create" class="bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" v-model="form.name" required autofocus>
            </div>
            <div class="flex items-center justify-between">
                <button
                    :disabled="form.processing"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Create
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import {Link, useForm} from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import GuildLayout from "@/Layouts/GuildLayout.vue";

export default {
    props: {
        guild: Object,
    },
    components: {
        GuildLayout,
        Link
    },
    data() {
        return {
            form: useForm({
                name: '',
            }),
        }
    },
    methods: {
        create() {

        }
    },
    layout: GuildLayout,
};
</script>

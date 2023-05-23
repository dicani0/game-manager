<template>
    <div class="w-full max-w-xs mx-auto my-20">
        <form @submit.prevent="login" class="bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">

                <label class="block text-gray-300 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
                    id="email" type="text" v-model="form.email" required>
                <div class="text-red-600" v-if="form.errors.email"> {{ form.errors.email }}</div>
            </div>
            <div class="mb-6">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
                    id="password" type="password" v-model="form.password" required>
                <div class="text-red-600" v-if="form.errors.password"> {{ form.errors.password }}</div>
            </div>
            <div class="flex items-center justify-between">
                <button
                    :disabled="form.processing"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Login
                </button>
            </div>
        </form>
    </div>
</template>

<script>

import {useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

export default {
    data() {
        return {
            form: useForm({
                email: '',
                password: '',
            }),
        }
    },
    methods: {
        login() {
            this.form.post('/auth/login', {
                onSuccess: (message) => {
                    useToast().success(message.props.flash.success)
                },
                onError: (errors) => {
                    Object.values(errors).forEach((error) => {
                        useToast().error(error);
                    });
                },
            });
        }
    }
}
;
</script>

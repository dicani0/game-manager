<template>
    <Head title="Register"/>
    <div class="w-full max-w-xs mx-auto my-20">
        <form @submit.prevent="register" class="bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="name">
                    Name
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
                    id="name" type="text" v-model="form.name" required autofocus>
            </div>
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="email">
                    Email
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
                    id="email" type="text" v-model="form.email" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
                    id="password" type="password" v-model="form.password" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-300 text-sm font-bold mb-2" for="password">
                    Confirm Password
                </label>
                <input
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
                    id="password_confirmation" type="password" v-model="form.password_confirmation" required>
            </div>
            <div class="flex items-center justify-between">
                <button
                    :disabled="form.processing"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Register
                </button>
            </div>
        </form>
    </div>
</template>

<script>

import {useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import {Head} from "@inertiajs/vue3";

export default {
    components: {
        Head,
    },
    data() {
        return {
            form: useForm({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            }),
        }
    },
    methods: {
        register() {
            this.form.post('/auth/register', {
                onError: (errors) => {
                    Object.values(errors).forEach((error) => {
                        useToast().error(error)
                    });
                },
                onSuccess: (message) => {
                    useToast().success(message.props.flash.success)
                },
            });
        }
    }
}
;
</script>

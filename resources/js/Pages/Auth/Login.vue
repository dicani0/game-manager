<template>
  <Head title="Login"/>
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
      <div class="mb-4">
        <label class="block text-gray-300 text-sm font-bold mb-2" for="password">
          Password
        </label>
        <input
            class="shadow appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline"
            id="password" type="password" v-model="form.password" required>
        <div class="text-red-600" v-if="form.errors.password"> {{ form.errors.password }}</div>
      </div>
      <div class="flex items-center justify-between mb-4">
        <button
            :disabled="form.processing"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
          Login
        </button>
      </div>
      <div class="flex flex-col">  <!-- This adds spacing between the buttons -->
        <Link href="/auth/forgot-password" class="text-blue-500 hover:text-blue-700">Forgot Password?</Link>
        <Link href="/auth/resend-verification" class="text-blue-500 hover:text-blue-700">Resend Verification Email
        </Link>
        <Link href="/auth/register" class="text-blue-500 hover:text-blue-700">Register</Link>
      </div>
    </form>
  </div>
</template>

<script>

import {Head, useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import {Link} from "@inertiajs/vue3";

export default {
  components: {
    Link,
    Head,
  },
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
      this.form.post('/auth/login');
    }
  }
}
;
</script>

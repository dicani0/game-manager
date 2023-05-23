<template>
    <div class="flex flex-col items-center justify-center bg-gray-800 p-4">
        <!-- User Profile Image -->
<!--        <img alt="User Image" class="w-32 h-32 object-cover rounded-full border-2 border-gray-600 mb-4"/>-->

        <!-- User Name -->
        <h2 class="text-2xl text-white font-bold mb-2">{{ user.name }}</h2>

        <!-- User Email -->
        <h3 class="text-xl text-gray-300 mb-4">{{ user.email }}</h3>

        <!-- User Bio -->
        <p class="text-gray-300 mb-4">Lorem ipsum</p>

        <!-- User Profile Links -->
        <div class="flex space-x-3">
            <a href="/auth/profile" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Profile</a>
            <a href="/settings" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Settings</a>
            <a href="/auth/logout" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Logout</a>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    user: Object
});

const user = ref(props.user);
</script>

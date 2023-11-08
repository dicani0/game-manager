<template>
    <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8 py-12 bg-gray-900 text-white">
        <form class="flex flex-col space-y-6" @submit.prevent="updateSettings">
            <div class="flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-400" for="discordName">Discord Name</label>
                <input id="discordName" v-model="settings.discord_name"
                       class="mt-1 w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 sm:text-sm text-white"
                       type="text">
            </div>

            <div class="flex items-center space-x-4 relative"
                 @mouseout="showTooltip = false"
                 @mouseover="showTooltip = true">
                <input id="private" v-model="settings.private" :checked="1 === 1"
                       class="form-checkbox h-5 w-5 text-blue-600 bg-blue-700" type="checkbox">
                <label class="text-sm font-medium text-gray-400" for="private">Private</label>
                <!-- Tooltip -->
                <div :class="{ 'tooltip-visible': showTooltip, 'tooltip-hidden': !showTooltip }"
                     class="absolute width-full tooltip-content -top-6 left-44 transform -translate-x-1/2 p-2 bg-gray-800 text-gray-300 rounded text-xs z-10">
                    Your items will be visible to other players and they will be able to request a trade.
                </div>
            </div>

            <div class="flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-400" for="newPassword">New password</label>
                <input id="newPassword" v-model="settings.password"
                       class="mt-1 w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 sm:text-sm text-white"
                       type="password">
            </div>

            <div class="flex flex-col space-y-2">
                <label class="text-sm font-medium text-gray-400" for="confirmPassword">Confirm new password</label>
                <input id="confirmPassword" v-model="settings.password_confirmation"
                       class="mt-1 w-full py-2 px-3 border border-gray-700 bg-gray-700 rounded-md focus:outline-none focus:ring focus:ring-indigo-200 sm:text-sm text-white"
                       type="password">
            </div>

            <button
                class="w-full py-2 px-4 bg-indigo-700 text-white font-semibold rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-opacity-50"
                type="submit">
                Save
            </button>
        </form>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    user: Object,
})

const showTooltip = ref(false);

const settings = ref({
    password: '',
    password_confirmation: '',
    discord_name: props.user.discord_name,
    private: Boolean(props.user.private),
});

const updateSettings = () => {
    const settingsToUpdate = {
        discord_name: settings.value.discord_name,
        private: Boolean(settings.value.private),
    };

    if (settings.value.password) {
        settingsToUpdate.password = settings.value.password;
        settingsToUpdate.password_confirmation = settings.value.password_confirmation;
    }

    router.patch('/auth/settings', settingsToUpdate)
};
</script>

<style scoped>
.tooltip-content {
    transition: opacity 0.3s ease-in-out;
}

.tooltip-visible {
    opacity: 1;
    visibility: visible;
    width: 200px;
}

.tooltip-hidden {
    opacity: 0;
    visibility: hidden;
}
</style>

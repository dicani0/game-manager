<template>
    <nav class="bg-gray-800 shadow py-2">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-center">
                <ul class="flex items-center space-x-4 gap-4">
                    <li>
                        <Link href="/auth/register" class="text-lg font-semibold hover:text-orange-300">
                            Home
                        </Link>
                    </li>
                    <li>
                        <Link href="/about" class="text-lg font-semibold hover:text-orange-300">
                            About
                        </Link>
                    </li>
                    <li v-if="!user">
                        <Link href="/auth/login" class="text-lg font-semibold hover:text-orange-300">
                            Login
                        </Link>
                    </li>
                    <li v-if="!user">
                        <Link href="/auth/register" class="text-lg font-semibold hover:text-orange-300">
                            Register
                        </Link>
                    </li>
                    <li v-if="user" class="relative group">
                        <div class="text-lg font-semibold hover:text-orange-300 cursor-pointer">
                            {{ user }}
                        </div>
                        <ul class="absolute left-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 transition-opacity duration-200 opacity-0 group-hover:opacity-100">
                            <li>
                                <Link href="/profile" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</Link>
                            </li>
                            <li>
                                <Link href="/settings" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Settings</Link>
                            </li>
                            <li>
                                <Link href="/auth/logout" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</Link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import {Link} from "@inertiajs/vue3";
export default {
    components: {
        Link
    },
    computed: {
        user() {
            return this.$page.props.auth?.user?.name;
        }
    },
};
</script>

<style scoped>

</style>

<template>
    <nav class="bg-gray-800 shadow py-2 border-b mb-2">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-center">
                <ul class="flex items-center space-x-4 gap-4">
                    <li>
                        <Link href="/" :class="{ 'text-teal-300': $page.component === 'Home' }" class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200">
                            <vue-feather type="home" class="mr-2"></vue-feather> Home
                        </Link>
                    </li>
                    <li>
                        <Link href="/about" :class="{ 'text-teal-300': $page.component === 'About' }" class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200">
                            <vue-feather type="info" class="mr-2"></vue-feather> About
                        </Link>
                    </li>
                    <li class="relative group">
                        <Link
                            :class="{ 'text-teal-300': $page.component.startsWith('Market/') }"
                            class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200"
                            href="/market"
                        >
                            <vue-feather type="dollar-sign" class="mr-2"></vue-feather> Market
                        </Link>

                        <ul v-if="user"
                            class="absolute left-0 mt-2 w-48 bg-gray-800 text-white rounded-lg shadow-lg py-2 transition-transform duration-200 transform scale-0 group-hover:scale-100 origin-top z-50"
                        >
                            <li>
                                <Link href="/market" class="block px-4 py-2 hover:bg-gray-200 hover:text-black">Offers</Link>
                            </li>
                            <li>
                                <Link href="/market/my" class="block px-4 py-2 hover:bg-gray-200 hover:text-black">My Offers</Link>
                            </li>
                            <li>
                                <Link href="/market/requests" class="block px-4 py-2 hover:bg-gray-200 hover:text-black">Requests</Link>
                            </li>
                            <li>
                                <Link href="/market/history" class="block px-4 py-2 hover:bg-gray-200 hover:text-black">History</Link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="user">
                        <Link href="/guild" :class="{ 'text-teal-300': $page.component === 'Guild/Guild' }" class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200">
                            <vue-feather type="aperture" class="mr-2"></vue-feather> Guilds
                        </Link>
                    </li>
                    <li v-if="user">
                        <Link href="/characters" :class="{ 'text-teal-300': $page.component === 'Character/Character' }" class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200">
                            <vue-feather type="columns" class="mr-2"></vue-feather> Characters
                        </Link>
                    </li>
                    <li v-if="user">
                        <Link href="/items" :class="{ 'text-teal-300': $page.component === 'Items/Item' }" class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200">
                            <vue-feather type="box" class="mr-2"></vue-feather> Items
                        </Link>
                    </li>
                    <li>
                        <Link href="/cosmetics" :class="{ 'text-teal-300': $page.component === 'Cosmetics/Cosmetic' }" class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200">
                            <vue-feather type="list" class="mr-2"></vue-feather> Cosmetics List
                        </Link>
                    </li>
                    <li v-if="!user">
                        <Link href="/auth/login" :class="{ 'text-teal-300': $page.component === 'Auth/Login' }" class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200">
                            <vue-feather type="log-in" class="mr-2"></vue-feather> Login
                        </Link>
                    </li>
                    <li v-if="!user">
                        <Link href="/auth/register" :class="{ 'text-teal-300': $page.component === 'Auth/Register' }" class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200">
                            <vue-feather type="user-plus" class="mr-2"></vue-feather> Register
                        </Link>
                    </li>
                    <li v-if="user" class="relative group">
                        <div
                            :class="{ 'text-teal-300': $page.component === 'Auth/Profile' }"
                            class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200"
                        >
                            <vue-feather type="user" class="mr-2"></vue-feather> {{ user }}
                        </div>

                        <!-- Dropdown Menu -->
                        <ul
                            class="absolute left-0 mt-2 w-32 bg-gray-800 text-white rounded-lg shadow-lg py-2 transition-transform duration-200 transform scale-0 group-hover:scale-100 origin-top z-50"
                        >
                            <li>
                                <Link href="/auth/profile" class="block px-4 py-2 hover:bg-gray-200 hover:text-black">Profile</Link>
                            </li>
                            <li>
                                <Link href="/characters" class="block px-4 py-2 hover:bg-gray-200 hover:text-black">Characters</Link>
                            </li>
                            <li>
                                <Link href="/settings" class="block px-4 py-2 hover:bg-gray-200 hover:text-black">Settings</Link>
                            </li>
                            <li>
                                <Link href="/auth/logout" class="block px-4 py-2 hover:bg-gray-200 hover:text-black">Logout</Link>
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

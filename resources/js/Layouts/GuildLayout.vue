<template>
    <Head title="Game Helper"/>
    <div class="h-screen bg-gray-900 text-gray-200 overflow-hidden">
        <Nav/>
        <div class="h-full bg-gray-900 text-white flex overflow-hidden">
            <!-- Sidebar -->
            <div class="bg-gray-800 w-1/12 h-100 p-4 overflow-auto flex-shrink-0">
                <h2 class="text-2xl mb-4">Guild Navigation</h2>
                <ul class="space-y-2">
                    <li>
                        <Link href="/guild/overview" class="text-lg hover:text-orange-300">
                            Overview
                        </Link>
                    </li>
                    <li>
                        <Link href="/guild/members" class="text-lg hover:text-orange-300">
                            Members
                        </Link>
                    </li>
                    <li>
                        <Link href="/guild/events" class="text-lg hover:text-orange-300">
                            Events
                        </Link>
                    </li>
                </ul>
            </div>

            <div class="p-4 overflow-auto">
                <h2 class="text-2xl mb-4">Guild Content</h2>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
import {Head, Link} from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import Nav from "@/Components/Nav.vue";

export default {
    components: {
        Layout,
        Link,
        Head,
        Nav,
    },

};
</script>

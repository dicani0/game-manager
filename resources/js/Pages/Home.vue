<template>
    <div class="bg-gray-900 text-white">
        <div class="grid grid-cols-3 gap-12 m-8">
            <Link href="/guild" class="bg-gray-800 p-4 rounded transition-all duration-200 transform hover:scale-105 hover:shadow-2xl hover:brightness-125 h-64">
                <h2 class="text-2xl mb-2">Guilds</h2>
                <p>Guild stuff</p>
            </Link>
            <Link href="/market" class="bg-gray-800 p-4 rounded transition-all duration-200 transform hover:scale-105 hover:shadow-2xl hover:brightness-125 h-64">
                <h2 class="text-2xl mb-2">Market</h2>
                <p>Market</p>
            </Link>
            <Link href="/page3" class="bg-gray-800 p-4 rounded transition-all duration-200 transform hover:scale-105 hover:shadow-2xl hover:brightness-125 h-64">
                <h2 class="text-2xl mb-2">Page 3</h2>
                <p>Description for Page 3</p>
            </Link>
            <Link href="/page1" class="bg-gray-800 p-4 rounded transition-all duration-200 transform hover:scale-105 hover:shadow-2xl hover:brightness-125 h-64">
                <h2 class="text-2xl mb-2">Page 1</h2>
                <p>Description for Page 1</p>
            </Link>
            <Link href="/page2" class="bg-gray-800 p-4 rounded transition-all duration-200 transform hover:scale-105 hover:shadow-2xl hover:brightness-125 h-64">
                <h2 class="text-2xl mb-2">Page 2</h2>
                <p>Description for Page 2</p>
            </Link>
            <Link href="/page3" class="bg-gray-800 p-4 rounded transition-all duration-200 transform hover:scale-105 hover:shadow-2xl hover:brightness-125 h-64">
                <h2 class="text-2xl mb-2">Page 3</h2>
                <p>Description for Page 3</p>
            </Link>
            <!-- Add more panels as needed -->
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    components: {
        Link
    },
};
</script>

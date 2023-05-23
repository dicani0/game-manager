<template>
    <h2 v-if="guild">{{ guild.name }}</h2>
    <h2 v-else>Not found</h2>
</template>

<script>
import {Link} from "@inertiajs/vue3";
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
    layout: GuildLayout,
};
</script>

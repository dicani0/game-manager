<template>
    <Head title="Game Helper"/>
    <div class="min-h-screen bg-gray-900 text-gray-200">
        <Nav/>
        <slot></slot>
    </div>
</template>

<script>
import {Head} from "@inertiajs/vue3";
import Nav from "@/Components/Nav.vue";

export default {
    components: {
        Nav,
        Head
    },
    computed: {
        errorMessages() {
            return this.$page.props.errors;
        }
    },
};
</script>

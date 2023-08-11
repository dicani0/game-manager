<template>
    <div class="min-h-screen bg-gray-900 text-gray-200">
        <Nav/>
        <slot></slot>
    </div>
</template>

<script>
import {Head} from "@inertiajs/vue3";
import Nav from "@/Components/Nav.vue";
import {useToast} from "vue-toastification";

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
    created() {
        if (this.$page.props.flash.success)
            setTimeout(() => {
                useToast().success(this.$page.props.flash.success);
            }, 0);
    }
};
</script>

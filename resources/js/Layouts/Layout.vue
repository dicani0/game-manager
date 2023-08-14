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
import {watch} from "vue";

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
        watch(() => this.$page.props.errors, () => {
            Object.values(this.$page.props.errors).forEach(error => {
                useToast().error(error);
            });
        })
        watch(() => this.$page.props.flash.success, () => {
            if (this.$page.props.flash.success) {
                useToast().success(this.$page.props.flash.success);
            }
        })
    }
};
</script>

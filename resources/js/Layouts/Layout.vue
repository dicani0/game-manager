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
    mounted() {
        this.listenForTradeOffers();
    },
    methods: {
        listenForTradeOffers() {
            console.log('Listening for trade offers');
            Echo.private(`trade-offers.${this.$page.props.auth.user.id}`)
                .listen('TradeOfferCreated', (e) => {
                    console.log('Trade offer created');
                })
        }
    }
};
</script>

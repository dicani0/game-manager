<template>
  <Head title="Game Helper"/>
  <div class="min-h-screen bg-gray-900 text-gray-200">
    <Nav/>
    <slot></slot>
  </div>
</template>

<script>
import {Head, router} from "@inertiajs/vue3";
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
  mounted() {
    this.listenForTradeOffers();
  },
  methods: {
    listenForTradeOffers() {
      Echo.private(`trade-offer.${this.$page.props.auth.user.id}`)
          .listen('.TradeOfferCreated', (e) => {
            //Check current component
            if (this.$page.component === 'Market/MyOffers') {
              this.$inertia.reload();
            }
            useToast().success('You have received a new trade offer!')
          })
          .error((error) => {
            console.error('Subscription Error:', error);
          });
    }
  }
};
</script>

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
import {watch} from "vue";

export default {
  components: {
    Nav,
    Head
  },
  props: {
    errors: Object,
    flash: Object,
    auth: Object,
    ziggy: Object,
  },
  mounted() {
    this.listenForTradeOffers();
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
  },
  methods: {
    listenForTradeOffers() {
      Echo.private(`trade-offer.${this.$page.props.auth.user?.id}`)
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

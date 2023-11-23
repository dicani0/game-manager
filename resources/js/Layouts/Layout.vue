<template>
  <Head title="Game Helper"/>
  <div class="min-h-screen bg-gray-900 text-gray-200 flex flex-col w-100">
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
    });
    watch(() => this.$page.props.flash.success, () => {
      if (this.$page.props.flash.success) {
        useToast().success(this.$page.props.flash.success);
      }
    });
    watch(() => this.$page.props.auth.user, (newUser, oldUser) => {
      if (newUser && !oldUser) {
        this.listenForTradeOffers();
        this.listenForGuildInvites();
        this.listenForGuildsNotifications();
      } else if (!newUser && oldUser) {
        Echo.leaveChannel(`trade-offer.${oldUser.id}`);
        Echo.leaveChannel(`guild-invite.${oldUser.id}`);
        this.leaveGuildChannels();
      }
    }, {immediate: true});
  },
  methods: {
    listenForTradeOffers() {
      Echo.private(`trade-offer.${this.$page.props.auth.user?.id}`)
          .listen('.TradeOfferCreated', (e) => {
            useToast().success('You have received a new trade offer!')
            if (this.$page.component === 'Market/MyOffers') {
              this.$inertia.reload();
            }
          })
          .error((error) => {
            console.error('Subscription Error:', error);
          });
    },
    listenForGuildInvites() {
      Echo.private(`guild-invite.${this.$page.props.auth.user?.id}`)
          .listen('.InvitedToGuild', (e) => {
            useToast().success('You have received a new guild invite!')
          })
          .error((error) => {
            console.error('Subscription Error:', error);
          });
    },
    listenForGuildsNotifications() {
      this.$page.props.my_guilds.forEach(guild => {
        Echo.join(`guild.${guild.id}`)
            .listen('.NewGuildCharacter', (e) => {
              useToast().success(`New guild member ${e.character.name} joined the guild!`)
            })
            .error((error) => {
              console.error('Subscription Error:', error);
            });
      })
    },
    leaveGuildChannels() {
      this.$page.props.my_guilds.forEach(guild => {
        Echo.leaveChannel(`guild.${guild.id}`);
      })
    }
  }
};
</script>

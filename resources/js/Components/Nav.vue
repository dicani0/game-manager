<template>
  <nav class="bg-gray-800 shadow py-2 border-b mb-2 min-w-full">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-center">
        <ul class="flex items-center space-x-4 gap-4">
          <li class="relative group">
            <Link
                :class="{ 'text-teal-300 bg-gray-900 rounded': $page.component.startsWith('Market/') }"
                class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200 px-2 py-1"
                href="/market"
            >
              <vue-feather class="mr-2" type="dollar-sign"></vue-feather>
              Market
            </Link>

            <ul v-if="user"
                class="absolute left-0 mt-2 w-48 bg-gray-800 text-white rounded-lg shadow-lg py-2 transition-transform duration-200 transform scale-0 group-hover:scale-100 origin-top z-50"
            >
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/market">Offers
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/market/my">My
                  Offers
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/market/history">
                  History
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black"
                      href="/market/requests">Requests
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/market/history">
                  History
                </Link>
              </li>
            </ul>
          </li>
          <li v-if="user">
            <Link :class="{ 'text-teal-300 bg-gray-900 rounded': $page.component === 'Auth/UsersList' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200 px-2 py-1"
                  href="/auth/users">
              <vue-feather class="mr-2" type="users"></vue-feather>
              Users
            </Link>
          </li>
          <li v-if="user" class="relative group">
            <Link
                :class="{ 'text-teal-300 bg-gray-900 rounded': $page.component.startsWith('Guild') }"
                class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200 px-2 py-1"
                href="/guilds"
            >
              <vue-feather class="mr-2" type="aperture"></vue-feather>
              Guilds
            </Link>

            <ul v-if="user"
                class="absolute left-0 mt-2 w-48 bg-gray-800 text-white rounded-lg shadow-lg py-2 transition-transform duration-200 transform scale-0 group-hover:scale-100 origin-top z-50"
            >
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/guilds">List
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/guilds/create">Create Guild
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/guilds?filter[my]=1">My Guilds
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/guilds/invites">Invites
                </Link>
              </li>
            </ul>
          </li>
          <li v-if="user">
            <Link :class="{ 'text-teal-300 bg-gray-900 rounded': $page.component === 'Character/Character' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200 px-2 py-1"
                  href="/characters">
              <vue-feather class="mr-2" type="columns"></vue-feather>
              Characters
            </Link>
          </li>
          <li v-if="user">
            <Link :class="{ 'text-teal-300 bg-gray-900 rounded': $page.component === 'Items/UserItems' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200 px-2 py-1"
                  href="/items/my">
              <vue-feather class="mr-2" type="box"></vue-feather>
              My Items
            </Link>
          </li>
          <li v-if="user">
            <Link :class="{ 'text-teal-300 bg-gray-900 rounded': $page.component === 'Items/AllItems' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200 px-2 py-1"
                  href="/items">
              <vue-feather class="mr-2" type="list"></vue-feather>
              Items List
            </Link>
          </li>
          <li v-if="user">
            <Link :class="{ 'text-teal-300 bg-gray-900 rounded': $page.component.startsWith('Poll') }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200 px-2 py-1"
                  href="/polls">
              <vue-feather class="mr-2" type="edit"></vue-feather>
              Polls
            </Link>
          </li>
          <li v-if="!user">
            <Link :class="{ 'text-teal-300 bg-gray-900 rounded': $page.component === 'Auth/Login' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200 px-2 py-1"
                  href="/auth/login">
              <vue-feather class="mr-2" type="log-in"></vue-feather>
              Login
            </Link>
          </li>
          <li v-if="!user">
            <Link :class="{ 'text-teal-300 bg-gray-900 rounded': $page.component === 'Auth/Register' }"
                  class="flex items-center text-lg font-bold text-yellow-300 hover:text-orange-300 transition-all duration-200"
                  href="/auth/register">
              <vue-feather class="mr-2" type="user-plus"></vue-feather>
              Register
            </Link>
          </li>
          <li v-if="user" class="relative group">
            <div
                :class="{ 'text-teal-300 bg-gray-900 rounded': $page.component === 'Auth/Profile' }"
                class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200"
            >
              <vue-feather class="mr-2" type="user"></vue-feather>
              {{ user }}
            </div>

            <!-- Dropdown Menu -->
            <ul
                class="absolute left-0 mt-2 w-32 bg-gray-800 text-white rounded-lg shadow-lg py-2 transition-transform duration-200 transform scale-0 group-hover:scale-100 origin-top z-50"
            >
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/auth/profile">
                  Profile
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/characters">
                  Characters
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/auth/settings">
                  Settings
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/auth/logout">
                  Logout
                </Link>
              </li>
            </ul>
          </li>
          <li v-if="user" class="relative">
            <button @click="toggleNotificationsDropdown"
                    class="flex items-center text-lg font-semibold text-white hover:text-orange-300 cursor-pointer transition-all duration-200 px-2">
              <vue-feather class="mr-2" type="bell"></vue-feather>
              Notifications <span class="text-cyan-400">{{
                notificationsCount > 0 ? '(' + notificationsCount + ')' : ''
              }}</span>
            </button>

            <ul v-if="showNotificationsDropdown && notifications.length"
                ref="dropdownMenu"
                class="absolute left-0 mt-2 w-96 bg-gray-800 text-white rounded-lg shadow-lg transition-transform duration-200 transform origin-top z-40">
              <li v-for="notification in notifications" :key="notification.id"
                  class="block px-4 py-2 hover:bg-gray-200 hover:text-black border-b-2 border-cyan-800">
                <Link :href="`/notifications/${notification.id}/read`"
                      class="font-bold text-cyan-700 cursor-pointer">
                  {{ notification.data.message }}
                </Link>
              </li>
              <div class="text-center flex flex-col">
                <Link class="bg-gray-900 hover:bg-gray-700 py-2" href="/notifications/all">
                  See all
                </Link>
                <Link class="bg-gray-900 hover:bg-gray-700 py-2" href="/notifications/read-all">
                  Read all
                </Link>
              </div>
            </ul>
          </li>

        </ul>
      </div>
    </div>
  </nav>
</template>


<script>
import {Link} from "@inertiajs/vue3";

export default {
  data() {
    return {
      showNotificationsDropdown: false,
      notifications: {
        type: Array,
        default: () => []
      }
    }
  },
  components: {
    Link
  },
  computed: {
    user() {
      return this.$page.props.auth?.user?.name;
    },
    notifications() {
      return this.$page.props.notifications;
    },
    notificationsCount() {
      return this.$page.props.notifications_count;
    }
  },
  methods: {
    toggleNotificationsDropdown() {
      this.showNotificationsDropdown = !this.showNotificationsDropdown;
      if (this.showNotificationsDropdown) {
        document.addEventListener('click', this.closeNotificationsDropdown, true);
      } else {
        document.removeEventListener('click', this.closeNotificationsDropdown, true);
      }
    },
    closeNotificationsDropdown(event) {
      const dropdownElement = this.$refs.dropdownMenu;
      if (dropdownElement && !dropdownElement.contains(event.target)) {
        this.showNotificationsDropdown = false;
        document.removeEventListener('click', this.closeNotificationsDropdown, true);
      }
    },
  },
  unmounted() {
    document.removeEventListener('click', this.closeNotificationsDropdown, true);
  }
};
</script>

<style scoped>

</style>

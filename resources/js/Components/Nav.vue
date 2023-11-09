<template>
  <nav class="bg-gray-800 shadow py-2 border-b mb-2">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-center">
        <ul class="flex items-center space-x-4 gap-4">
          <li>
            <Link :class="{ 'text-teal-300': $page.component === 'Home' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200"
                  href="/">
              <vue-feather class="mr-2" type="home"></vue-feather>
              Home
            </Link>
          </li>
          <li>
            <Link :class="{ 'text-teal-300': $page.component === 'About' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200"
                  href="/about">
              <vue-feather class="mr-2" type="info"></vue-feather>
              About
            </Link>
          </li>
          <li class="relative group">
            <Link
                :class="{ 'text-teal-300': $page.component.startsWith('Market/') }"
                class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200"
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
            <Link :class="{ 'text-teal-300': $page.component === 'Auth/UsersList' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200"
                  href="/auth/users">
              <vue-feather class="mr-2" type="users"></vue-feather>
              Users
            </Link>
          </li>
          <li v-if="user" class="relative group">
            <Link
                :class="{ 'text-teal-300': $page.component.startsWith('GuildIndexQuery/') }"
                class="flex items-center text-lg font-semibold hover:text-orange-300 cursor-pointer transition-all duration-200"
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
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/guilds?my=1">My Guilds
                </Link>
              </li>
              <li>
                <Link class="block px-4 py-2 hover:bg-gray-200 hover:text-black" href="/guilds?my=1">Invites
                </Link>
              </li>
            </ul>
          </li>
          <li v-if="user">
            <Link :class="{ 'text-teal-300': $page.component === 'Character/Character' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200"
                  href="/characters">
              <vue-feather class="mr-2" type="columns"></vue-feather>
              Characters
            </Link>
          </li>
          <li v-if="user">
            <Link :class="{ 'text-teal-300': $page.component === 'Items/UserItems' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200"
                  href="/items/my">
              <vue-feather class="mr-2" type="box"></vue-feather>
              My Items
            </Link>
          </li>
          <li>
            <Link :class="{ 'text-teal-300': $page.component === 'Items/AllItems' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200"
                  href="/items">
              <vue-feather class="mr-2" type="list"></vue-feather>
              Items List
            </Link>
          </li>
          <li v-if="!user">
            <Link :class="{ 'text-teal-300': $page.component === 'Auth/Login' }"
                  class="flex items-center text-lg font-semibold hover:text-orange-300 transition-all duration-200"
                  href="/auth/login">
              <vue-feather class="mr-2" type="log-in"></vue-feather>
              Login
            </Link>
          </li>
          <li v-if="!user">
            <Link :class="{ 'text-teal-300': $page.component === 'Auth/Register' }"
                  class="flex items-center text-lg font-bold text-yellow-300 hover:text-orange-300 transition-all duration-200"
                  href="/auth/register">
              <vue-feather class="mr-2" type="user-plus"></vue-feather>
              Register
            </Link>
          </li>
          <li v-if="user" class="relative group">
            <div
                :class="{ 'text-teal-300': $page.component === 'Auth/Profile' }"
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

        </ul>
      </div>
    </div>
  </nav>
</template>


<script>
import {Link} from "@inertiajs/vue3";

export default {
  components: {
    Link
  },
  computed: {
    user() {
      return this.$page.props.auth?.user?.name;
    }
  },
};
</script>

<style scoped>

</style>

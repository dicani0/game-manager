<template>
  <Modal :open="open" :width="'w-1/6'" class="transition-all" @close="closeInviteModal">
    <div v-if="characters && characters.data.length < 1" class="text-center">
      <p>There's no characters that can be invited!</p>
    </div>
    <div class="my-4 p-4">
      <ul>
        <li v-for="character in characters?.data" :key="character.id" class="flex justify-between items-center my-2">
          <span>{{ character.name }}</span>
          <button
              class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded text-xs"
              @click="inviteCharacter(character.id)"
          >
            Invite
          </button>
        </li>
      </ul>
    </div>
    <div class="flex gap-2 justify-evenly">
      <button
          :class="buttonClass(isFirstPage)"
          :disabled="isFirstPage"
          class="font-bold py-1 px-2 rounded"
          @click="changePage(-1)"
      >
        Previous Page
      </button>
      <button
          :class="buttonClass(isLastPage)"
          :disabled="isLastPage"
          class="font-bold py-1 px-2 rounded"
          @click="changePage(1)"
      >
        Next Page
      </button>
    </div>
  </Modal>
</template>

<script lang="ts" setup>
import {computed, defineEmits, defineProps, watch} from 'vue';
import Modal from "@/Components/Modal.vue";
import {router} from "@inertiajs/vue3";
import {CharactersPagination, Guild} from "@/types/Guild";


const props = defineProps<{
  open: boolean;
  characters?: CharactersPagination;
  guild: Guild;
}>();

const emit = defineEmits(['invited', 'closeInviteModal']);

watch(() => props.open, (newOpenValue: boolean) => {
  if (newOpenValue) {
    router.reload({only: ['characters'], data: {page: 1}});
  }
});

const closeInviteModal = () => {
  emit('closeInviteModal', false);
}

const isFirstPage = computed(() => props.characters?.current_page <= 1);
const isLastPage = computed(() => props.characters?.current_page >= props.characters?.last_page);

const changePage = (direction: number) => {
  if (props.characters) {
    const newPage = props.characters.current_page + direction;
    router.reload({only: ['characters'], data: {page: newPage}});
  }
};

const buttonClass = (isDisabled: boolean) => [
  'bg-yellow-500 hover:bg-yellow-600 text-white',
  isDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-yellow-700'
];

const inviteCharacter = (characterId: number) => {
  const page = props.characters?.current_page || 1;

  router.post(`/guilds/${props.guild.id}/invite/${characterId}`, {}, {
    preserveState: true,
    onSuccess: () => {
      emit('invited', page);
    }
  });
};
</script>

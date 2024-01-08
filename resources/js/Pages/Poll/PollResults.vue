<template>
  <div
      class="container mt-4 mx-auto flex flex-col justify-center items-center w-full bg-gray-800 p-8 rounded-2xl shadow-inner shadow-2xl shadow-cyan-400">
    <h1 class="text-4xl font-bold mb-4">{{ poll.title }}</h1>
    <p class="text-lg mb-8">{{ poll.description }}</p>
    <ul class="w-full">
      <li v-for="question in poll.questions" :key="question.id" class="mb-6 mx-auto max-w-xl">
        <h2 class="text-2xl font-semibold mb-2">{{ question.question }}</h2>
        <ul class="w-full">
          <li v-for="answer in question.answers" :key="answer.id" class="mb-2 mx-auto max-w-xl">
            <div class="flex items-center">
              <span>{{ answer.content }}</span>
              <span class="ml-4">{{ answer.votes_count }} {{ answer.votes_count === 1 ? 'Vote' : 'Votes' }}</span>
            </div>
            <div class="h-2 relative max-w-xl rounded-full overflow-hidden">
              <div class="w-full h-full bg-gray-200 absolute"></div>
              <div class="h-full bg-green-500 absolute transition-all duration-500 ease-in-out"
                   :style="{width: `${(answer.votes_count / question.votes_count) * 100}%`}"></div>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import {Poll} from "@/types/Poll";

const props = defineProps<{
  poll: Poll;
}>();
</script>
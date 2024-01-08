<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex items-center gap-2">
      <h1 class="text-2xl font-bold">{{ poll.title }}</h1>
    </div>
    <div class="rounded-lg bg-gray-800 p-4 shadow-md">
      <p class="text-lg text-white break-words">{{ poll.description }}</p>
      <div class="mt-4">
        <ul>
          <li v-for="question in poll.questions" :key="question.id" class="mb-4 pl-4">
            <p class="text-lg font-medium text-white">{{ question.question }}</p>
            <p class="text-sm text-gray-400">{{ question.type }}</p>
            <ul class="mt-2 gap-4">
              <li v-for="(answer, index) in question.answers" :key="answer.id" class="mb-2">
                <p class="text-base text-gray-300 break-words">{{ answer.content }}</p>
                <div v-if="question.id !== undefined && answer.id !== undefined">
                  <input type="checkbox" @change="selectAnswer(question.id, answer.id)"
                         v-if="question.type === AnswerTypeEnum.MULTIPLE">
                  <input type="radio" @change="selectAnswer(question.id, answer.id)" :name="`question-${question.id}`"
                         v-if="question.type === AnswerTypeEnum.SINGLE">
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="flex gap-2">
        <button @click="submit" class="h-10 px-4 py-2 bg-blue-500 hover:bg-blue-800 text-white rounded">Vote</button>
        <Link class="h-10 px-4 py-2 bg-green-500 hover:bg-green-800 text-white rounded"
              :href="`${poll.id}/results`">
          Show results
        </Link>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {Poll} from "@/types/Poll";
import {AnswerTypeEnum} from "@/Enums/AnswerTypeEnum";
import {Link, useForm} from "@inertiajs/vue3";

const props = defineProps<{
  poll: Poll;
}>();

let form = useForm({
  questions: props.poll.questions.map((question) => ({
    question_id: question.id,
    answers: [] as { answer_id: number }[]
  }))
});

const selectAnswer = (questionId: number, answerId: number) => {
  const questionFormData = form.questions.find(question => question.question_id === questionId);
  if (!questionFormData) return;

  const index = questionFormData.answers.findIndex(answer => answer.answer_id === answerId);
  if (props.poll.questions.find(question => question.id === questionId)?.type === 'SINGLE') {
    questionFormData.answers = [{answer_id: answerId}];
  } else if (index === -1) {
    questionFormData.answers.push({answer_id: answerId});
  } else {
    questionFormData.answers.splice(index, 1);
  }
};

const submit = () => {
  form.post(`/polls/${props.poll.id}/vote`)
};

</script>
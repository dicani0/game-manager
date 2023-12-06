<template>
  <div class="p-6 max-w-7xl min-w-[33%] mx-auto bg-gray-800 text-white rounded-xl shadow-md">
    <div class="text-xl font-medium text-white mb-4">Update {{ props.poll.title }}</div>

    <form @submit.prevent="updatePoll">
      <div class="mb-4">
        <label class="block text-gray-500 text-sm font-bold mb-2" for="poll-title">Poll Title</label>
        <input v-model="form.title"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
               id="poll-title" type="text" required>
      </div>

      <div class="mb-4">
        <label class="block text-gray-500 text-black text-sm font-bold mb-2" for="poll-description">Description</label>
        <textarea id="poll-description" class="w-full text-gray-500" rows="3" v-model="form.description"></textarea>
      </div>

      <div class="flex mb-2">
        <div class="flex-1">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="poll-start-date">Start Date</label>
          <input v-model="form.start_date"
                 class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
                 id="poll-start-date" type="datetime-local" required>
        </div>

        <div class="flex-1">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="poll-end-date">End Date</label>
          <input v-model="form.end_date"
                 class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
                 id="poll-end-date" type="datetime-local" required>
        </div>
      </div>

      <!-- Questions -->
      <div v-for="(question, qIndex) in form.questions" :key="qIndex" class="mb-6">
        <div class="mb-4">
          <label class="block text-gray-500 text-sm font-bold mb-2" :for="'question-' + qIndex">Question {{
              qIndex + 1
            }}</label>
          <div class="flex">
            <input v-model="question.question"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
                   :id="'question-' + qIndex" type="text" required>
            <button v-if="canDeleteQuestion" :disabled="!canDeleteQuestion" type="button"
                    @click="removeQuestion(qIndex)"
                    class="ml-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex-initial w-48"
                    :class="{'cursor-not-allowed bg-red-800 hover:bg-red-800': !canDeleteQuestion}">
              Remove Question
            </button>
          </div>
        </div>
        <div class="mb-4">
          <label class="block text-gray-500 text-sm font-bold mb-2" :for="'question-type-' + qIndex">Question
            Type</label>
          <select v-model="question.type"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
                  :id="'question-type-' + qIndex">
            <option value="single">Single Answer</option>
            <option value="multiple">Multiple Answer</option>
          </select>
        </div>

        <!-- Answers -->
        <div v-for="(answer, aIndex) in question.answers" :key="aIndex" class="mb-4 mx-16">
          <div class="flex-grow p-0 m-0">
            <label class="block text-gray-500 text-sm font-bold mb-2" :for="'answer-' + qIndex + '-' + aIndex">Answer
              {{ aIndex + 1 }}</label>
          </div>
          <div class="flex">
            <input v-model="answer.content"
                   class="shadow appearance-none border rounded py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline w-full"
                   :id="'answer-' + qIndex + '-' + aIndex" type="text" required>
            <button v-if="canDeleteQuestionAnswer(qIndex)" type="button" @click="removeAnswer(qIndex, aIndex)"
                    class="ml-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex-initial w-48">
              Remove Answer
            </button>
          </div>
        </div>

        <!-- Add Answer Button -->
        <div class="flex justify-center">
          <button type="button" @click="addAnswer(qIndex)"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline"
                  :disabled="isMaxAnswersReached(qIndex)">
            Add Answer
          </button>
        </div>

      </div>

      <!-- Add Question Button -->
      <button type="button" @click="addQuestion"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
              :disabled="form.questions.length >= 15">
        Add Question
      </button>

      <div class="flex items-center justify-between mt-6">
        <button
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            type="submit">
          Update Poll
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import {computed, onMounted, ref} from 'vue';
import {useForm} from "@inertiajs/vue3";
import {Poll} from "@/types/Poll";

const MAX_QUESTIONS = 15;
const MIN_QUESTIONS = 1;
const MAX_ANSWERS = 10;
const MIN_ANSWERS = 2;

const props = defineProps<{
  poll: Poll
}>()

const description = ref('');

const form = useForm({
  title: props.poll.title,
  description: props.poll.description,
  start_date: props.poll.start_date,
  end_date: props.poll.end_date,
  questions: props.poll.questions,
});


function createQuestion() {
  return {
    question: '',
    type: 'single',
    answers: [createAnswer(), createAnswer()],
  };
}

function createAnswer() {
  return {content: ''};
}


const addQuestion = () => {
  if (form.questions.length < MAX_QUESTIONS) {
    form.questions.push(createQuestion());
  }
};

const addAnswer = (questionIndex: number) => {
  if (form.questions[questionIndex].answers.length < MAX_ANSWERS) {
    form.questions[questionIndex].answers.push(createAnswer());
  }
};

const canDeleteQuestion = computed(() => form.questions.length > MIN_QUESTIONS);
const canDeleteQuestionAnswer = (questionIndex: number) => form.questions[questionIndex].answers.length > MIN_ANSWERS;


const removeAnswer = (questionIndex: number, answerIndex: number) => {
  const answers = form.questions[questionIndex].answers;
  if (answers.length > MIN_ANSWERS) {
    answers.splice(answerIndex, 1);
  }
};

const removeQuestion = (questionIndex: number) => {
  if (form.questions.length > MIN_QUESTIONS) {
    form.questions.splice(questionIndex, 1);
  }
};

const isMaxAnswersReached = (questionIndex: number) => {
  return form.questions[questionIndex].answers.length >= MAX_ANSWERS;
};

function convertIsoToLocalDateTime(isoString: string) {
  const date = new Date(isoString);
  const offset = date.getTimezoneOffset() * 60000;
  const localISOTime = new Date(date.getTime() - offset).toISOString();
  return localISOTime.slice(0, 16);
}

onMounted(() => {
  form.start_date = convertIsoToLocalDateTime(props.poll.start_date);
  form.end_date = convertIsoToLocalDateTime(props.poll.end_date);
})

const updatePoll = () => {
  form.transform((data) => {
    return {
      ...data,
      start_date: new Date(data.start_date).toISOString(),
      end_date: new Date(data.end_date).toISOString()
    }
  })
      .put(`/polls/${props.poll.id}`)
};
</script>


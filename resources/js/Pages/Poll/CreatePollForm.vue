<template>
  <div class="p-6 max-w-7xl min-w-[33%] mx-auto bg-gray-800 text-white rounded-xl shadow-md">
    <div class="text-xl font-medium text-white mb-4">Create Poll</div>

    <form @submit.prevent="createPoll">
      <div class="mb-4">
        <label class="block text-gray-500 text-sm font-bold mb-2" for="poll-title">Poll Title</label>
        <input v-model="form.title"
               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
               id="poll-title" type="text" required>
      </div>

      <!-- Questions -->
      <div v-for="(question, qIndex) in form.questions" :key="qIndex" class="mb-6">
        <div class="mb-4">
          <label class="block text-gray-500 text-sm font-bold mb-2" :for="'question-' + qIndex">Question {{
              qIndex + 1
            }}</label>
          <input v-model="question.text"
                 class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
                 :id="'question-' + qIndex" type="text" required>
        </div>
        <div class="mb-4">
          <label class="block text-gray-500 text-sm font-bold mb-2" :for="'question-type-' + qIndex">Question
            Type</label>
          <select v-model="question.type"
                  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
                  :id="'question-type-' + qIndex">
            <option value="single">Single Option</option>
            <option value="multi">Multiple Options</option>
          </select>
        </div>

        <!-- Answers -->
        <div v-for="(answer, aIndex) in question.answers" :key="aIndex" class="mb-4 mx-16">
          <label class="block text-gray-500 text-sm font-bold mb-2" :for="'answer-' + qIndex + '-' + aIndex">Answer
            {{ aIndex + 1 }}</label>
          <input v-model="answer.text"
                 class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight focus:outline-none focus:shadow-outline"
                 :id="'answer-' + qIndex + '-' + aIndex" type="text" required>

          <button type="button" @click="removeAnswer(qIndex, aIndex)"
                  class="ml-4 bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline">
            Remove Answer
          </button>
        </div>

        <!-- Add Answer Button -->
        <button type="button" @click="addAnswer(qIndex)"
                class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline"
                :disabled="question.answers.length >= 10">
          Add Answer
        </button>

        <button type="button" @click="removeQuestion(qIndex)"
                class="mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
          Remove Question
        </button>

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
            type="submit" :disabled="form.processing">
          Create Poll
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import {reactive} from 'vue';

const form = reactive({
  title: '',
  questions: [],
});

const addQuestion = () => {
  form.questions.push({
    text: '',
    type: 'single',
    answers: [
      {
        text: '',
      },
      {
        text: '',
      }
    ],
  });
};

const addAnswer = (questionIndex) => {
  form.questions[questionIndex].answers.push({
    text: '',
  });
};

const removeAnswer = (questionIndex, answerIndex) => {
  form.questions[questionIndex].answers.splice(answerIndex, 1);
};

const removeQuestion = (questionIndex) => {
  form.questions.splice(questionIndex, 1);
};

const createPoll = () => {
};
</script>
``

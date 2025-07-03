import { ref } from 'vue';
import { Posttest, Question } from '@/services/posttestService';

export function usePosttestForm() {
  const posttestForm = ref<Posttest>({
    title: '',
    description: '',
    questions: [],
  });

  const addQuestion = () => {
    const newOrder = posttestForm.value.questions.length > 0
      ? Math.max(...posttestForm.value.questions.map(q => q.order || 0)) + 1
      : 1;
    posttestForm.value.questions.push({
      question_text: '',
      option_a: '',
      option_b: '',
      option_c: '',
      option_d: '',
      correct_answer: 'A',
      order: newOrder,
    });
  };

  const removeQuestion = (index: number) => {
    posttestForm.value.questions.splice(index, 1);
    // Re-order questions after removal
    posttestForm.value.questions.forEach((q, i) => {
      q.order = i + 1;
    });
  };

  const setPosttestForm = (posttest: Posttest) => {
    posttestForm.value = JSON.parse(JSON.stringify(posttest)); // Deep copy
  };

  return {
    posttestForm,
    addQuestion,
    removeQuestion,
    setPosttestForm,
  };
}

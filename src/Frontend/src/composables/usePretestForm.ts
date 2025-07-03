import { ref, Ref } from 'vue';
import { Pretest, Question } from '@/services/pretestService';

export function usePretestForm() {
  const pretestForm: Ref<Pretest> = ref({
    title: '',
    description: '',
    questions: [],
  });

  const addQuestion = () => {
    pretestForm.value.questions.push({
      question_text: '',
      option_a: '',
      option_b: '',
      option_c: '',
      option_d: '',
      correct_answer: 'A',
      order: pretestForm.value.questions.length + 1,
    });
  };

  const removeQuestion = (index: number) => {
    pretestForm.value.questions.splice(index, 1);
    // Re-order questions after removal
    pretestForm.value.questions.forEach((q, i) => {
      q.order = i + 1;
    });
  };

  const setPretestForm = (pretest: Pretest) => {
    pretestForm.value = JSON.parse(JSON.stringify(pretest)); // Deep copy
  };

  return {
    pretestForm,
    addQuestion,
    removeQuestion,
    setPretestForm,
  };
}

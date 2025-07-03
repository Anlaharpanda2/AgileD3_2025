import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/kelola/pretests'; // Adjust if your backend URL is different

export interface Question {
  id?: number;
  question_text: string;
  option_a: string;
  option_b: string;
  option_c: string;
  option_d: string;
  correct_answer: 'A' | 'B' | 'C' | 'D';
  order: number;
}

export interface Pretest {
  id?: number;
  title: string;
  description: string;
  questions: Question[];
  is_active?: boolean;
}

const pretestService = {
  async getAllPretests(): Promise<Pretest[]> {
    const response = await axios.get(API_URL);
    return response.data;
  },

  async getPretestById(id: number): Promise<Pretest> {
    const response = await axios.get(`${API_URL}/${id}`);
    return response.data;
  },

  async createPretest(pretest: Pretest): Promise<Pretest> {
    const response = await axios.post(API_URL, pretest);
    return response.data;
  },

  async updatePretest(id: number, pretest: Pretest): Promise<Pretest> {
    const response = await axios.put(`${API_URL}/${id}`, pretest);
    return response.data;
  },

  async deletePretest(id: number): Promise<void> {
    await axios.delete(`${API_URL}/${id}`);
  },

  async updatePretestVisibility(pretests: { id: number; is_active: boolean }[]): Promise<void> {
    await axios.put(`${API_URL}/visibility`, { pretests });
  },

  async submitPretestAnswers(pretestId: number, answers: { question_id: number; selected_option: 'A' | 'B' | 'C' | 'D' }[], userNik: string, userName: string): Promise<any> {
    const response = await axios.post(`${API_URL}/${pretestId}/submit-answers`, {
      answers,
      user_nik: userNik,
      user_name: userName,
    });
    return response.data;
  },

  async getUserInfoByNik(nik: string): Promise<any> {
    const response = await axios.get(`http://127.0.0.1:8000/api/kelola/pelatihan/${nik}`); // Adjust URL if needed
    return response.data;
  },
};

export default pretestService;

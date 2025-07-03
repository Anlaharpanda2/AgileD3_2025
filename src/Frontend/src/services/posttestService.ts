import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/kelola/posttests'; // Adjust if your backend URL is different

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

export interface Posttest {
  id?: number;
  title: string;
  description: string;
  questions: Question[];
  is_active?: boolean;
}

const posttestService = {
  async getAllPosttests(): Promise<Posttest[]> {
    const response = await axios.get(API_URL);
    return response.data;
  },

  async getPosttestById(id: number): Promise<Posttest> {
    const response = await axios.get(`${API_URL}/${id}`);
    return response.data;
  },

  async createPosttest(posttest: Posttest): Promise<Posttest> {
    const response = await axios.post(API_URL, posttest);
    return response.data;
  },

  async updatePosttest(id: number, posttest: Posttest): Promise<Posttest> {
    const response = await axios.put(`${API_URL}/${id}`, posttest);
    return response.data;
  },

  async deletePosttest(id: number): Promise<void> {
    await axios.delete(`${API_URL}/${id}`);
  },

  async updatePosttestVisibility(posttests: { id: number; is_active: boolean }[]): Promise<void> {
    await axios.put(`${API_URL}/visibility`, { posttests });
  },

  async submitPosttestAnswers(posttestId: number, answers: { question_id: number; selected_option: 'A' | 'B' | 'C' | 'D' }[], userNik: string, userName: string): Promise<any> {
    const response = await axios.post(`${API_URL}/${posttestId}/submit-answers`, {
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

export default posttestService;

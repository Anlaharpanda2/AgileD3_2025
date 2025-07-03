import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/data/nilai';

export interface User {
  name: string;
}

export interface PretestScore {
  id: number;
  nik: string;
  pretest_score: number;
  posttest_score: number | null;
  kategori: string;
  tanggal: string;
  user: User;
}

const pretestScoreService = {
  async getAllPretestScores(): Promise<PretestScore[]> {
    const response = await axios.get(API_URL);
    return response.data;
  },
};

export default pretestScoreService;
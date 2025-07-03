import axios from 'axios';

const API_URL = 'http://127.0.0.1:8000/api/data/combined-scores';

export interface CombinedScore {
  id: number;
  user_nik: string;
  user_name: string;
  pretest_score: number | null;
  posttest_score: number | null;
}

const combinedScoreService = {
  async getAllCombinedScores(): Promise<CombinedScore[]> {
    const response = await axios.get(API_URL);
    return response.data;
  },

  async getCombinedScoreByNik(nik: string): Promise<CombinedScore> {
    const response = await axios.get(`${API_URL}/${nik}`);
    return response.data;
  },
};

export default combinedScoreService;

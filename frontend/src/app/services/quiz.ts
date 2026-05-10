import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { AuthService } from './auth';

@Injectable({ providedIn: 'root' })
export class QuizService {
  private apiUrl = 'http://localhost/sistema-quiz-online/backend/routes/api.php';

  constructor(private http: HttpClient, private auth: AuthService) {}

  private getHeaders() {
    const token = this.auth.getToken();
    return {
      headers: new HttpHeaders({
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
      })
    };
  }

  getAllQuizzes() {
    return this.http.get(`${this.apiUrl}?endpoint=quizzes`);
  }

  getQuizById(id: number) {
    return this.http.get(`${this.apiUrl}?endpoint=quiz&id=${id}`);
  }

  createQuiz(title: string, description: string) {
    return this.http.post(`${this.apiUrl}?endpoint=quiz`, { title, description }, this.getHeaders());
  }

  updateQuiz(id: number, title: string, description: string) {
    return this.http.put(`${this.apiUrl}?endpoint=quiz`, { id, title, description }, this.getHeaders());
  }

  deleteQuiz(id: number) {
    return this.http.delete(`${this.apiUrl}?endpoint=quiz&id=${id}`, this.getHeaders());
  }

  // Métodos para perguntas
  addQuestion(quizId: number, questionText: string, questionType: string = 'multiple_choice') {
    return this.http.post(`${this.apiUrl}?endpoint=question`, 
      { quiz_id: quizId, question_text: questionText, question_type: questionType }, 
      this.getHeaders());
  }

  updateQuestion(id: number, questionText: string, questionType: string = 'multiple_choice') {
    return this.http.put(`${this.apiUrl}?endpoint=question`, 
      { id, question_text: questionText, question_type: questionType }, 
      this.getHeaders());
  }

  deleteQuestion(id: number) {
    return this.http.delete(`${this.apiUrl}?endpoint=question&id=${id}`, this.getHeaders());
  }

  // Métodos para respostas
  addAnswer(questionId: number, answerText: string, isCorrect: boolean) {
    return this.http.post(`${this.apiUrl}?endpoint=answer`, 
      { question_id: questionId, answer_text: answerText, is_correct: isCorrect }, 
      this.getHeaders());
  }

  updateAnswer(id: number, answerText: string, isCorrect: boolean) {
    return this.http.put(`${this.apiUrl}?endpoint=answer`, 
      { id, answer_text: answerText, is_correct: isCorrect }, 
      this.getHeaders());
  }

  deleteAnswer(id: number) {
    return this.http.delete(`${this.apiUrl}?endpoint=answer&id=${id}`, this.getHeaders());
  }
}

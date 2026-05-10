import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({ providedIn: 'root' })
export class ExternalApiService {
  private apiUrl = 'https://opentdb.com/api.php';

  constructor(private http: HttpClient) {}

  getTriviaQuestions(amount: number = 5, category?: string, difficulty?: string): Observable<any> {
    let url = `${this.apiUrl}?amount=${amount}&type=multiple`;
    if (category && category !== '') url += `&category=${category}`;
    if (difficulty && difficulty !== '') url += `&difficulty=${difficulty}`;
    return this.http.get(url);
  }

  getCategories(): Observable<any> {
    return this.http.get('https://opentdb.com/api_category.php');
  }
}

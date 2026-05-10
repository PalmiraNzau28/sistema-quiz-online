import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { QuizService } from '../../services/quiz';
import { DynamicTranslationService } from '../../services/dynamic-translation';

@Component({
  selector: 'app-quiz-list',
  standalone: false,
  templateUrl: './quiz-list.html',
  styleUrls: ['./quiz-list.css']
})
export class QuizList implements OnInit {
  quizzes: any[] = [];
  loading = true;
  error = '';

  constructor(
    private quizService: QuizService,
    private cd: ChangeDetectorRef,
    private dynamicTranslate: DynamicTranslationService
  ) {}

  ngOnInit() {
    this.loadQuizzes();
  }

  loadQuizzes() {
    this.loading = true;
    this.cd.detectChanges();
    
    this.quizService.getAllQuizzes().subscribe({
      next: (response: any) => {
        if (response.success) {
          // Aplica tradução dinâmica aos quizzes
          this.dynamicTranslate.translateQuizzes(response.quizzes).subscribe({
            next: (translatedQuizzes) => {
              this.quizzes = translatedQuizzes;
              this.loading = false;
              this.cd.detectChanges();
            },
            error: (translationError) => {
              console.error('Erro na tradução dos quizzes:', translationError);
              // Mesmo com erro na tradução, mostra os quizzes originais
              this.quizzes = response.quizzes;
              this.loading = false;
              this.cd.detectChanges();
            }
          });
        } else {
          this.error = 'Erro ao carregar quizzes';
          this.loading = false;
          this.cd.detectChanges();
        }
      },
      error: () => {
        this.error = 'Erro de conexão com o servidor';
        this.loading = false;
        this.cd.detectChanges();
      }
    });
  }
}
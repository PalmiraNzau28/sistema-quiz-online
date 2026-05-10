import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { QuizService } from '../../services/quiz';
import { ExportService } from '../../services/export';
import { DynamicTranslationService } from '../../services/dynamic-translation';

@Component({
  selector: 'app-quiz-detail',
  standalone: false,
  templateUrl: './quiz-detail.html',
  styleUrls: ['./quiz-detail.css']
})
export class QuizDetail implements OnInit {
  quiz: any = null;
  answers: { [key: number]: number } = {};
  loading = true;
  error = '';
  submitted = false;
  score = 0;
  totalQuestions = 0;

  constructor(
    private route: ActivatedRoute,
    private quizService: QuizService,
    private exportService: ExportService,
    private cd: ChangeDetectorRef,
    private dynamicTranslate: DynamicTranslationService
  ) {}

  ngOnInit() {
    const id = this.route.snapshot.params['id'];
    console.log('ID do quiz:', id);
    this.loadQuiz(id);
  }

  loadQuiz(id: number) {
    this.loading = true;
    this.cd.detectChanges();
    console.log('A carregar quiz ID:', id);
    
    this.quizService.getQuizById(id).subscribe({
      next: (response: any) => {
        console.log('Resposta recebida:', response);
        
        if (response.success && response.quiz) {
          // Aplica tradução dinâmica ao quiz
          this.dynamicTranslate.translateQuiz(response.quiz).subscribe({
            next: (translatedQuiz) => {
              this.quiz = translatedQuiz;
              this.totalQuestions = this.quiz.questions ? this.quiz.questions.length : 0;
              console.log('✓ Quiz carregado e traduzido:', this.quiz.title);
              console.log('✓ Número de perguntas:', this.totalQuestions);
              this.loading = false;
              this.cd.detectChanges();
            },
            error: (translationError) => {
              console.error('✗ Erro na tradução:', translationError);
              // Mesmo com erro na tradução, mostra o quiz original
              this.quiz = response.quiz;
              this.totalQuestions = this.quiz.questions ? this.quiz.questions.length : 0;
              this.loading = false;
              this.cd.detectChanges();
            }
          });
        } else {
          this.error = 'Quiz não encontrado';
          console.error('Erro: Quiz não encontrado na resposta');
        }
        
        this.loading = false;
        this.cd.detectChanges();
        console.log('Loading definido como:', this.loading);
      },
      error: (err) => {
        console.error('Erro na requisição:', err);
        this.error = 'Erro ao carregar quiz: ' + (err.message || 'Erro desconhecido');
        this.loading = false;
        this.cd.detectChanges();
      }
    });
  }

  isFormComplete(): boolean {
    const complete = Object.keys(this.answers).length === this.totalQuestions && this.totalQuestions > 0;
    console.log('Formulário completo?', complete, 'Respostas:', Object.keys(this.answers).length, 'Total:', this.totalQuestions);
    return complete;
  }

  submitQuiz() {
    this.score = 0;
    
    for (const question of this.quiz.questions) {
      const selectedAnswerId = this.answers[question.id];
      const selectedAnswer = question.answers.find((a: any) => a.id === selectedAnswerId);
      
      if (selectedAnswer && selectedAnswer.is_correct === 1) {
        this.score++;
      }
    }
    
    this.submitted = true;
    this.cd.detectChanges();
  }

  exportToCSV() {
    const userAnswers = this.prepareUserAnswers();
    this.exportService.exportToCSV(this.quiz.title, userAnswers, this.score, this.totalQuestions);
  }

  exportToPDF() {
    const userAnswers = this.prepareUserAnswers();
    this.exportService.exportToPDF(this.quiz.title, userAnswers, this.score, this.totalQuestions);
  }

  private prepareUserAnswers() {
    const userAnswers = [];
    
    for (const question of this.quiz.questions) {
      const selectedAnswerId = this.answers[question.id];
      const selectedAnswer = question.answers.find((a: any) => a.id === selectedAnswerId);
      const isCorrect = selectedAnswer && selectedAnswer.is_correct === 1;
      
      userAnswers.push({
        questionText: question.question_text,
        selectedAnswer: selectedAnswer ? selectedAnswer.answer_text : 'Não respondida',
        isCorrect: isCorrect
      });
    }
    
    return userAnswers;
  }
}
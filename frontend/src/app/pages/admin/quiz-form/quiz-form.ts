import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { QuizService } from '../../../services/quiz';
import { ExternalApiService } from '../../../services/external-api';
import { DynamicTranslationService } from '../../../services/dynamic-translation';

@Component({
  selector: 'app-quiz-form',
  standalone: false,
  templateUrl: './quiz-form.html',
  styleUrls: ['./quiz-form.css']
})
export class QuizForm implements OnInit {
  title = '';
  description = '';
  quizId: number | null = null;
  isEditMode = false;
  loading = false;
  errorMessage = '';
  
  // Propriedades para API externa
  apiCategory = '';
  apiDifficulty = '';
  apiAmount = 5;
  apiMessage = '';
  importing = false;
  categories: any[] = [];

  constructor(
    private quizService: QuizService,
    private route: ActivatedRoute,
    private router: Router,
    private externalApi: ExternalApiService,
    private dynamicTranslation: DynamicTranslationService
  ) {}

  ngOnInit() {
    this.quizId = this.route.snapshot.params['id'];
    if (this.quizId) {
      this.isEditMode = true;
      this.loadQuiz();
    }
    
    // Carregar categorias da API externa
    this.externalApi.getCategories().subscribe({
      next: (response: any) => {
        this.categories = response.trivia_categories || [];
      },
      error: () => {
        console.log('Erro ao carregar categorias da API');
      }
    });
  }

  loadQuiz() {
    this.loading = true;
    this.quizService.getQuizById(this.quizId!).subscribe({
      next: (response: any) => {
        if (response.success) {
          // Aplica tradução dinâmica ao quiz carregado
          this.dynamicTranslation.translateQuiz(response.quiz).subscribe({
            next: (translatedQuiz) => {
              this.title = translatedQuiz.title;
              this.description = translatedQuiz.description || '';
              this.loading = false;
            },
            error: (translationError) => {
              console.error('Erro na tradução do quiz:', translationError);
              // Mesmo com erro na tradução, carrega os dados originais
              this.title = response.quiz.title;
              this.description = response.quiz.description || '';
              this.loading = false;
            }
          });
        } else {
          this.errorMessage = 'Erro ao carregar quiz';
          this.loading = false;
        }
      },
      error: () => {
        this.errorMessage = 'Erro ao carregar quiz';
        this.loading = false;
      }
    });
  }

  onSubmit() {
    if (!this.title) {
      this.errorMessage = 'O título é obrigatório';
      return;
    }

    this.loading = true;
    this.errorMessage = '';

    if (this.isEditMode) {
      this.quizService.updateQuiz(this.quizId!, this.title, this.description).subscribe({
        next: (response: any) => {
          if (response.success) {
            this.router.navigate(['/quizzes']);
          } else {
            this.errorMessage = response.message;
          }
          this.loading = false;
        },
        error: () => {
          this.errorMessage = 'Erro ao atualizar quiz';
          this.loading = false;
        }
      });
    } else {
      this.quizService.createQuiz(this.title, this.description).subscribe({
        next: (response: any) => {
          if (response.success) {
            this.quizId = response.quiz_id;
            this.isEditMode = true;
            this.errorMessage = '';
            this.loading = false;
          } else {
            this.errorMessage = response.message;
            this.loading = false;
          }
        },
        error: () => {
          this.errorMessage = 'Erro ao criar quiz';
          this.loading = false;
        }
      });
    }
  }

  importFromAPI() {
    if (!this.quizId) {
      this.apiMessage = 'Primeiro guarde o quiz antes de importar perguntas.';
      return;
    }

    this.importing = true;
    this.apiMessage = 'A buscar perguntas da API externa...';
    
    this.externalApi.getTriviaQuestions(
      this.apiAmount, 
      this.apiCategory || undefined, 
      this.apiDifficulty || undefined
    ).subscribe({
      next: (response: any) => {
        if (response.response_code === 0) {
          this.saveImportedQuestions(response.results);
        } else {
          this.apiMessage = 'Nenhuma pergunta encontrada. Tente outros parâmetros.';
          this.importing = false;
          setTimeout(() => { this.apiMessage = ''; }, 3000);
        }
      },
      error: () => {
        this.apiMessage = 'Erro ao conectar com a API externa.';
        this.importing = false;
        setTimeout(() => { this.apiMessage = ''; }, 3000);
      }
    });
  }

  private saveImportedQuestions(questions: any[]) {
    let savedCount = 0;
    const totalQuestions = questions.length;
    
    questions.forEach((q: any) => {
      // Criar pergunta no quiz
      this.quizService.addQuestion(this.quizId!, this.decodeHtml(q.question), 'multiple_choice')
        .subscribe({
          next: (questionResponse: any) => {
            if (questionResponse.success) {
              const questionId = questionResponse.question_id;
              
              // Preparar todas as respostas
              const answers = [
                { text: this.decodeHtml(q.correct_answer), correct: true },
                ...q.incorrect_answers.map((ans: string) => ({ 
                  text: this.decodeHtml(ans), 
                  correct: false 
                }))
              ];
              
              // Embaralhar as respostas
              answers.sort(() => Math.random() - 0.5);
              
              // Adicionar cada resposta
              answers.forEach(answer => {
                this.quizService.addAnswer(questionId, answer.text, answer.correct).subscribe();
              });
              
              savedCount++;
              
              if (savedCount === totalQuestions) {
                this.apiMessage = `${savedCount} perguntas importadas com sucesso!`;
                this.importing = false;
                setTimeout(() => { this.apiMessage = ''; }, 3000);
              }
            } else {
              this.apiMessage = 'Erro ao salvar algumas perguntas.';
              this.importing = false;
            }
          },
          error: () => {
            this.apiMessage = 'Erro ao salvar perguntas.';
            this.importing = false;
          }
        });
    });
  }

  private decodeHtml(text: string): string {
    const txt = document.createElement('textarea');
    txt.innerHTML = text;
    return txt.value;
  }
}

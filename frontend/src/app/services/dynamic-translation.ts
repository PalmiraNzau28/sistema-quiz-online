import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of, forkJoin } from 'rxjs';
import { map, catchError, switchMap } from 'rxjs/operators';
import { TranslationService } from './translation';

@Injectable({ providedIn: 'root' })
export class DynamicTranslationService {
  private cache: Map<string, string> = new Map();
  private translationApiUrl = 'https://api.mymemory.translated.net/get';

  constructor(
    private http: HttpClient,
    private translationService: TranslationService
  ) {}

  /**
   * Traduz um texto dinâmico para o idioma atual
   * @param text Texto a ser traduzido
   * @param sourceLang Idioma de origem (padrão: 'en' para inglês)
   * @returns Observable com o texto traduzido
   */
  translateText(text: string, sourceLang: string = 'en'): Observable<string> {
    if (!text || text.trim() === '') {
      return of(text);
    }

    const currentLang = this.translationService.getCurrentLang();

    // Se o idioma atual for o mesmo que o de origem, retorna o texto original
    if (currentLang === sourceLang) {
      return of(text);
    }

    // Verifica se já está no cache
    const cacheKey = `${sourceLang}_${currentLang}_${text}`;
    if (this.cache.has(cacheKey)) {
      return of(this.cache.get(cacheKey)!);
    }

    // Faz a tradução via API
    const params = {
      q: text,
      langpair: `${sourceLang}|${currentLang}`,
      de: 'quiz-system@example.com'
    };

    return this.http.get(this.translationApiUrl, { params }).pipe(
      map((response: any) => {
        const translatedText = response?.responseData?.translatedText || text;
        // Cacheia a tradução
        this.cache.set(cacheKey, translatedText);
        return translatedText;
      }),
      catchError(() => {
        // Em caso de erro, retorna o texto original
        console.warn('Erro ao traduzir texto:', text);
        return of(text);
      })
    );
  }

  /**
   * Traduz um quiz completo (título, descrição, perguntas e respostas)
   * @param quiz Objeto do quiz
   * @param sourceLang Idioma de origem
   * @returns Observable com o quiz traduzido
   */
  translateQuiz(quiz: any, sourceLang: string = 'en'): Observable<any> {
    if (!quiz) return of(quiz);

    const currentLang = this.translationService.getCurrentLang();

    // Se não precisa traduzir, retorna o quiz original
    if (currentLang === sourceLang) {
      return of(quiz);
    }

    const translatedQuiz = { ...quiz };

    // Traduz título e descrição
    const titleTranslation$ = this.translateText(quiz.title || '', sourceLang);
    const descriptionTranslation$ = this.translateText(quiz.description || '', sourceLang);

    return forkJoin([titleTranslation$, descriptionTranslation$]).pipe(
      switchMap(([translatedTitle, translatedDescription]) => {
        translatedQuiz.title = translatedTitle;
        translatedQuiz.description = translatedDescription;

        // Traduz perguntas se existirem
        if (quiz.questions && Array.isArray(quiz.questions)) {
          return this.translateQuestions(quiz.questions, sourceLang).pipe(
            map(translatedQuestions => {
              translatedQuiz.questions = translatedQuestions;
              return translatedQuiz;
            })
          );
        }

        return of(translatedQuiz);
      })
    );
  }

  /**
   * Traduz um array de perguntas com suas respostas
   * @param questions Array de perguntas
   * @param sourceLang Idioma de origem
   * @returns Observable com as perguntas traduzidas
   */
  translateQuestions(questions: any[], sourceLang: string = 'en'): Observable<any[]> {
    if (!questions || questions.length === 0) {
      return of(questions);
    }

    const currentLang = this.translationService.getCurrentLang();

    // Se não precisa traduzir, retorna as perguntas originais
    if (currentLang === sourceLang) {
      return of(questions);
    }

    // Traduz cada pergunta individualmente
    const questionTranslations$ = questions.map(question => {
      const questionTextTranslation$ = this.translateText(question.question_text || '', sourceLang);

      let answersTranslation$: Observable<any[]>;
      if (question.answers && Array.isArray(question.answers)) {
        answersTranslation$ = this.translateAnswers(question.answers, sourceLang);
      } else {
        answersTranslation$ = of([]);
      }

      return forkJoin([questionTextTranslation$, answersTranslation$]).pipe(
        map(([translatedQuestionText, translatedAnswers]) => ({
          ...question,
          question_text: translatedQuestionText,
          answers: translatedAnswers
        }))
      );
    });

    return forkJoin(questionTranslations$);
  }

  /**
   * Traduz um array de respostas
   * @param answers Array de respostas
   * @param sourceLang Idioma de origem
   * @returns Observable com as respostas traduzidas
   */
  private translateAnswers(answers: any[], sourceLang: string = 'en'): Observable<any[]> {
    if (!answers || answers.length === 0) {
      return of(answers);
    }

    const answerTranslations$ = answers.map(answer =>
      this.translateText(answer.answer_text || '', sourceLang).pipe(
        map(translatedText => ({
          ...answer,
          answer_text: translatedText
        }))
      )
    );

    return forkJoin(answerTranslations$);
  }

  /**
   * Traduz um array de quizzes
   * @param quizzes Array de quizzes
   * @param sourceLang Idioma de origem
   * @returns Observable com os quizzes traduzidos
   */
  translateQuizzes(quizzes: any[], sourceLang: string = 'en'): Observable<any[]> {
    if (!quizzes || quizzes.length === 0) {
      return of(quizzes);
    }

    const quizTranslations$ = quizzes.map(quiz => this.translateQuiz(quiz, sourceLang));
    return forkJoin(quizTranslations$);
  }

  /**
   * Limpa o cache de traduções
   */
  clearCache(): void {
    this.cache.clear();
  }

  /**
   * Obtém estatísticas do cache
   */
  getCacheStats(): { size: number; keys: string[] } {
    return {
      size: this.cache.size,
      keys: Array.from(this.cache.keys())
    };
  }
}
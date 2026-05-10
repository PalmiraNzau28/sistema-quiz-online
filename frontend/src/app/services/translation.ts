import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root' })
export class TranslationService {
  private currentLang = 'pt';
  private translations: any = {
    pt: {
      // Geral
      'app.title': 'Quiz Online',
      'nav.quizzes': 'Quizzes',
      'nav.newQuiz': 'Novo Quiz',
      'nav.login': 'Login',
      'nav.register': 'Registar',
      'nav.logout': 'Sair',
      
      // Login
      'login.title': 'Login',
      'login.email': 'Email',
      'login.password': 'Palavra-passe',
      'login.button': 'Entrar',
      'login.loading': 'A entrar...',
      'login.registerLink': 'Não tem conta? Registe-se',
      'login.error': 'Email ou palavra-passe incorretos',
      
      // Register
      'register.title': 'Registo',
      'register.name': 'Nome',
      'register.email': 'Email',
      'register.password': 'Palavra-passe',
      'register.passwordHint': 'Mínimo 6 caracteres, com maiúscula, minúscula e número',
      'register.button': 'Registar',
      'register.loading': 'A registar...',
      'register.loginLink': 'Já tem conta? Faça login',
      'register.success': 'Registo bem-sucedido! Redirecionando para login...',
      
      // Quizzes
      'quizzes.title': 'Quizzes Disponíveis',
      'quizzes.loading': 'A carregar...',
      'quizzes.noQuizzes': 'Nenhum quiz disponível no momento.',
      'quizzes.start': 'Iniciar Quiz',
      'quizzes.createdBy': 'Criado por:',
      'quizzes.noDescription': 'Sem descrição',
      
      // Quiz Detail
      'quiz.submit': 'Submeter Respostas',
      'quiz.back': 'Voltar aos Quizzes',
      'quiz.score': 'Pontuação',
      'quiz.correct': 'Acertaste em',
      'quiz.questions': 'perguntas',
      'quiz.exportCSV': 'Exportar CSV',
      'quiz.exportPDF': 'Exportar PDF',
      
      // Quiz Form
      'quizForm.create': 'Criar Novo Quiz',
      'quizForm.edit': 'Editar Quiz',
      'quizForm.title': 'Título *',
      'quizForm.description': 'Descrição',
      'quizForm.cancel': 'Cancelar',
      'quizForm.save': 'Guardar',
      'quizForm.update': 'Atualizar',
      'quizForm.saving': 'A guardar...',
      'quizForm.importFromAPI': 'Importar da API Externa',
      'quizForm.anyCategory': 'Qualquer Categoria',
      'quizForm.anyDifficulty': 'Qualquer Dificuldade',
      'quizForm.easy': 'Fácil',
      'quizForm.medium': 'Médio',
      'quizForm.hard': 'Difícil',
      'quizForm.importQuestions': 'Buscar e Importar',
      'quizForm.importing': 'A importar...'
    },
    en: {
      // General
      'app.title': 'Quiz Online',
      'nav.quizzes': 'Quizzes',
      'nav.newQuiz': 'New Quiz',
      'nav.login': 'Login',
      'nav.register': 'Register',
      'nav.logout': 'Logout',
      
      // Login
      'login.title': 'Login',
      'login.email': 'Email',
      'login.password': 'Password',
      'login.button': 'Login',
      'login.loading': 'Logging in...',
      'login.registerLink': 'Don\'t have an account? Register',
      'login.error': 'Invalid email or password',
      
      // Register
      'register.title': 'Register',
      'register.name': 'Name',
      'register.email': 'Email',
      'register.password': 'Password',
      'register.passwordHint': 'Minimum 6 characters, with uppercase, lowercase and number',
      'register.button': 'Register',
      'register.loading': 'Registering...',
      'register.loginLink': 'Already have an account? Login',
      'register.success': 'Registration successful! Redirecting to login...',
      
      // Quizzes
      'quizzes.title': 'Available Quizzes',
      'quizzes.loading': 'Loading...',
      'quizzes.noQuizzes': 'No quizzes available at the moment.',
      'quizzes.start': 'Start Quiz',
      'quizzes.createdBy': 'Created by:',
      'quizzes.noDescription': 'No description',
      
      // Quiz Detail
      'quiz.submit': 'Submit Answers',
      'quiz.back': 'Back to Quizzes',
      'quiz.score': 'Score',
      'quiz.correct': 'You got',
      'quiz.questions': 'questions correct',
      'quiz.exportCSV': 'Export CSV',
      'quiz.exportPDF': 'Export PDF',
      
      // Quiz Form
      'quizForm.create': 'Create New Quiz',
      'quizForm.edit': 'Edit Quiz',
      'quizForm.title': 'Title *',
      'quizForm.description': 'Description',
      'quizForm.cancel': 'Cancel',
      'quizForm.save': 'Save',
      'quizForm.update': 'Update',
      'quizForm.saving': 'Saving...',
      'quizForm.importFromAPI': 'Import from External API',
      'quizForm.anyCategory': 'Any Category',
      'quizForm.anyDifficulty': 'Any Difficulty',
      'quizForm.easy': 'Easy',
      'quizForm.medium': 'Medium',
      'quizForm.hard': 'Hard',
      'quizForm.importQuestions': 'Fetch & Import',
      'quizForm.importing': 'Importing...'
    }
  };

  constructor() {
    const savedLang = localStorage.getItem('language');
    if (savedLang) {
      this.currentLang = savedLang;
    }
  }

  get(key: string): string {
    return this.translations[this.currentLang][key] || key;
  }

  setLanguage(lang: string) {
    this.currentLang = lang;
    localStorage.setItem('language', lang);
  }

  getCurrentLang(): string {
    return this.currentLang;
  }
}
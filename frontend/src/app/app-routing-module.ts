import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { Login } from './pages/login/login';
import { Register } from './pages/register/register';
import { QuizList } from './components/quiz-list/quiz-list';
import { QuizDetail } from './components/quiz-detail/quiz-detail';
import { QuizForm } from './pages/admin/quiz-form/quiz-form';

const routes: Routes = [
  { path: '', redirectTo: '/quizzes', pathMatch: 'full' },
  { path: 'login', component: Login },
  { path: 'register', component: Register },
  { path: 'quizzes', component: QuizList },
  { path: 'quiz/:id', component: QuizDetail },
  { path: 'admin/quiz/new', component: QuizForm },
  { path: 'admin/quiz/edit/:id', component: QuizForm }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

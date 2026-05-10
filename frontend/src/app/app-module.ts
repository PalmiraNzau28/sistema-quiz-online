import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing-module';
import { App } from './app';
import { Header } from './components/header/header';
import { Footer } from './components/footer/footer';
import { QuizList } from './components/quiz-list/quiz-list';
import { QuizDetail } from './components/quiz-detail/quiz-detail';
import { Login } from './pages/login/login';
import { Register } from './pages/register/register';
import { QuizForm } from './pages/admin/quiz-form/quiz-form';
import { TranslatePipe } from './pipes/translate.pipe';

@NgModule({
  declarations: [App, Header, Footer, QuizList, QuizDetail, Login, Register, QuizForm, TranslatePipe],
  imports: [BrowserModule, AppRoutingModule, HttpClientModule, FormsModule],
  providers: [],
  bootstrap: [App],
})
export class AppModule { }
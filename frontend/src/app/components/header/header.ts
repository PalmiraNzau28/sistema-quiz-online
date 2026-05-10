import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth';
import { ThemeService } from '../../services/theme';
import { TranslationService } from '../../services/translation';

@Component({
  selector: 'app-header',
  standalone: false,
  templateUrl: './header.html',
  styleUrls: ['./header.css']
})
export class Header {
  isDarkMode = false;
  currentLang = 'pt';

  constructor(
    public auth: AuthService, 
    private router: Router,
    private themeService: ThemeService,
    private translation: TranslationService
  ) {
    this.isDarkMode = this.themeService.getCurrentTheme() === 'dark';
    this.currentLang = this.translation.getCurrentLang();
  }

  isLoggedIn(): boolean {
    return this.auth.isLoggedIn();
  }

  isAdmin(): boolean {
    return this.auth.isAdmin();
  }

  logout(): void {
    this.auth.logout();
    this.router.navigate(['/login']);
  }

  toggleTheme(): void {
    this.themeService.toggleTheme();
    this.isDarkMode = !this.isDarkMode;
  }

  changeLanguage(lang: string): void {
    this.translation.setLanguage(lang);
    this.currentLang = lang;
  }
}

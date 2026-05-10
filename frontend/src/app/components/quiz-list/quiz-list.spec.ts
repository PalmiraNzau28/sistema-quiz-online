import { ComponentFixture, TestBed } from '@angular/core/testing';

import { QuizList } from './quiz-list';

describe('QuizList', () => {
  let component: QuizList;
  let fixture: ComponentFixture<QuizList>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [QuizList],
    }).compileComponents();

    fixture = TestBed.createComponent(QuizList);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ActiveBudgetListComponent } from './active-budget-list.component';

describe('ActiveBudgetListComponent', () => {
  let component: ActiveBudgetListComponent;
  let fixture: ComponentFixture<ActiveBudgetListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ActiveBudgetListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ActiveBudgetListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

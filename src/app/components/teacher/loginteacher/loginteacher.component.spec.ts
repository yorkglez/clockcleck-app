import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LoginteacherComponent } from './loginteacher.component';

describe('LoginteacherComponent', () => {
  let component: LoginteacherComponent;
  let fixture: ComponentFixture<LoginteacherComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LoginteacherComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LoginteacherComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

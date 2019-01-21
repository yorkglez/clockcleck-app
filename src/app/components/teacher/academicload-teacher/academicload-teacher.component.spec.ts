import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AcademicloadTeacherComponent } from './academicload-teacher.component';

describe('AcademicloadTeacherComponent', () => {
  let component: AcademicloadTeacherComponent;
  let fixture: ComponentFixture<AcademicloadTeacherComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AcademicloadTeacherComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AcademicloadTeacherComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

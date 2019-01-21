import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PorfileTeacherComponent } from './porfile-teacher.component';

describe('PorfileTeacherComponent', () => {
  let component: PorfileTeacherComponent;
  let fixture: ComponentFixture<PorfileTeacherComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PorfileTeacherComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PorfileTeacherComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { AcademicloadlistComponent } from './academicloadlist.component';

describe('AcademicloadlistComponent', () => {
  let component: AcademicloadlistComponent;
  let fixture: ComponentFixture<AcademicloadlistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ AcademicloadlistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(AcademicloadlistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

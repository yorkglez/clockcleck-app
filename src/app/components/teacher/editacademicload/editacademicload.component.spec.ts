import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditacademicloadComponent } from './editacademicload.component';

describe('EditacademicloadComponent', () => {
  let component: EditacademicloadComponent;
  let fixture: ComponentFixture<EditacademicloadComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditacademicloadComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditacademicloadComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

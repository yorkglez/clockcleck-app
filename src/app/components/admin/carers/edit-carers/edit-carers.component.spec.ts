import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditCarersComponent } from './edit-carers.component';

describe('EditCarersComponent', () => {
  let component: EditCarersComponent;
  let fixture: ComponentFixture<EditCarersComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditCarersComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditCarersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

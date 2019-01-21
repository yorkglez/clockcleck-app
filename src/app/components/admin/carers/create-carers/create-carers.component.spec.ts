import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateCarersComponent } from './create-carers.component';

describe('CreateCarersComponent', () => {
  let component: CreateCarersComponent;
  let fixture: ComponentFixture<CreateCarersComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CreateCarersComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateCarersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

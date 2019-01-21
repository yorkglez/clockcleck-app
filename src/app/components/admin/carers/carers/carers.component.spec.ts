import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CarersComponent } from './carers.component';

describe('CarersComponent', () => {
  let component: CarersComponent;
  let fixture: ComponentFixture<CarersComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CarersComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CarersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

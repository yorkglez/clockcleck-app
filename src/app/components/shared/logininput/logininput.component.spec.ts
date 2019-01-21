import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { LogininputComponent } from './logininput.component';

describe('LogininputComponent', () => {
  let component: LogininputComponent;
  let fixture: ComponentFixture<LogininputComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ LogininputComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(LogininputComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

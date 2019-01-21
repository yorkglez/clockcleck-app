import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateExtensionsComponent } from './create-extensions.component';

describe('CreateExtensionsComponent', () => {
  let component: CreateExtensionsComponent;
  let fixture: ComponentFixture<CreateExtensionsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CreateExtensionsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CreateExtensionsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

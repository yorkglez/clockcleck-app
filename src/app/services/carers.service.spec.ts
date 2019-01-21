import { TestBed, inject } from '@angular/core/testing';

import { CarersService } from './carers.service';

describe('CarersService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [CarersService]
    });
  });

  it('should be created', inject([CarersService], (service: CarersService) => {
    expect(service).toBeTruthy();
  }));
});

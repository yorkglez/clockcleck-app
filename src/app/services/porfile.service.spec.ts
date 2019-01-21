import { TestBed, inject } from '@angular/core/testing';

import { PorfileService } from './porfile.service';

describe('PorfileService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [PorfileService]
    });
  });

  it('should be created', inject([PorfileService], (service: PorfileService) => {
    expect(service).toBeTruthy();
  }));
});

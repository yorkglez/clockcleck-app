import { TestBed, async, inject } from '@angular/core/testing';

import { ValidGuard } from './valid.guard';

describe('ValidGuard', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [ValidGuard]
    });
  });

  it('should ...', inject([ValidGuard], (guard: ValidGuard) => {
    expect(guard).toBeTruthy();
  }));
});

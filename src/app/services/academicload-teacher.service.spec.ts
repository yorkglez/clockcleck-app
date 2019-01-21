import { TestBed, inject } from '@angular/core/testing';

import { AcademicloadTeacherService } from './academicload-teacher.service';

describe('AcademicloadTeacherService', () => {
  beforeEach(() => {
    TestBed.configureTestingModule({
      providers: [AcademicloadTeacherService]
    });
  });

  it('should be created', inject([AcademicloadTeacherService], (service: AcademicloadTeacherService) => {
    expect(service).toBeTruthy();
  }));
});

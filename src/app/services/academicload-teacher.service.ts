import { Injectable } from '@angular/core';
import { ScheduleService,Hour } from './schedule.service';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AcademicloadTeacherService {

  private hours = [
       "7:00",
       "7:50",
       "8:40",
       "9:30",
       "10:20",
       "10:50",
       "11:40",
       "12:30",
       "13:20",
       "14:10",
       "15:00"
  ]
  private days = [
    "lunes",
    "martes",
    "miercoles",
    "jueves",
    "viernes"
  ]
  constructor(private http: HttpClient) { }

  AssingSubject(model) {
    return this.http.post('api/queries/Academicload/AssingSubjectTeacher.php',JSON.stringify(model))
  }
  Update(model) {
    return this.http.post('api/queries/Academicload/updateSubjectlist.php',JSON.stringify(model))
  }

  getAcademicloadList():Observable<acList[]>{
    return this.http.get<acList[]>('api/queries/Academicload/getAcademicloadList.php');
  }
  searchAcademiadloadList(ter: string, extension: string):Observable<acList[]>{
    return this.http.get<acList[]>('api/queries/Academicload/searchAcademicloadList.php',{params:{ ter: ter,extension: extension}});
  }
  getAcademicload():Observable<acload[]>{
      return this.http.get<acload[]>('api/queries/Academicload/getAcademicloadTeacher.php');
  }
  Delete(id:string){
    return this.http.post('api/queries/Academicload/Delete.php',id)
  }
  getHours(){
    return this.hours
  }
  getDays(){
    return this.days
  }
}
export interface Schedule {
  startTime:string,
  endTime:string,
  day:string,
  subjectid:string
}
export interface acload{
  codeTeacher: string,
  idSubjectlist: string,
  nameSubject: string,
  alias: string,
  startTime: string,
  endTime: string,
  day: string,
  objetive: string
}
export interface acList {
  code:string,
  teacherName:string
}
export interface subjectList {
    grade:string,
    cicle:string,
    teacherCode:string,
    subjectCode:string,
    idsemester:string
}

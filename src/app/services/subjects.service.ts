import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class SubjectsService {
  url = 'http://api.malastareas.com.mx/Queries/Subject/';
  constructor(private http: HttpClient) { }

  getSubjects(status,ter,sequence): Observable<Subject[]>{
    return this.http.get<Subject[]>('api/queries/Subject/getSubjects.php',{params:{status: status,ter: ter, sequence: sequence}})
  }

  getSubjectList(): Observable<SubjectList[]>{
    return this.http.get<SubjectList[]>('api/queries/Subject/getSubjectsList.php')
  }

  searchSubject(ter:string,type:string): Observable<Subject[]>{
    ter = ter.toLowerCase()
    return this.http.get<Subject[]>('api/queries/Subject/searchSubject.php',{params:{ter: ter, type: type}})
  }
  //
  saveSubject(model,sequence) {
    return this.http.post('api/queries/Subject/saveSubject.php',{model: JSON.stringify(model),sequence: sequence})
  }

  updateSubject(model,id) {
    return this.http.post('api/queries/Subject/Update.php',{model: model,id: id})
  }
  // updateSubject(model,removes,news,id) {
  //   return this.http.post('api/queries/Subject/updateSubject.php',{model: JSON.stringify(model),id: id})
  // }

  // deleteSubject(id:string){
  //   return this.http.post('api/queries/Subject/deleteSubject.php',JSON.stringify(id))
  // }

  changeStatus(id:string, status:string){
    return this.http.post('api/queries/Subject/changeStatus.php',{id,status});
  }
  getCarerbyType(type:string){
    return this.http.get<Subject[]>('api/queries/Subject/getDatabyType.php',{params:{type:type}})
  }
  getSubjectbyId(id:string):Observable<Subject[]>{
    return this.http.get<Subject[]>('api/queries/Subject/getSubject.php',{params:{id:id}})
  }
  removeSquence(code){
    return this.http.post('api/queries/Subject/removeSquence.php',JSON.stringify(code))
  }
  getSubjectsListTeacher(code): Observable<SubjectList[]>{
        return this.http.get<SubjectList[]>('api/queries/Subject/getSubjectsListTeacher.php',{params:{code:code}})
  }

}

export interface SubjectList{
  codeSubject:string,
  name:string
}

export interface Subject{
  codeSubject:string,
  name:string,
  credits:string,
  sequence:string
}

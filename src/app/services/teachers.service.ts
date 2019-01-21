import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class TeachersService {

  constructor(private http: HttpClient) { }

  getData(ter:string,type:string,extension): Observable<Teacher[]>{
    return this.http.get<Teacher[]>('api/queries/Teacher/getData.php',{params:{ter: ter, type: type,extension: extension}})
  }


  Search(ter:string,type:string,extension:string): Observable<Teacher[]>{
    ter = ter.toLowerCase()
    return this.http.get<Teacher[]>('api/queries/Teacher/searchTeacher.php',{params:{ter: ter, type: type,extension: extension}})
  }
  Save(model) {
    return this.http.post('api/queries/Teacher/saveUser.php',JSON.stringify(model))
  }
  Update(model,id) {
    return this.http.post('api/queries/Teacher/updateTeacher.php',{model: JSON.stringify(model),id: id})
  }
  changeStatus(id:string, status:string){
    return this.http.post<Response>('api/queries/Teacher/changeStatus.php',{id: id, status: status})
  }
  getTeacherbyType(type:string){
    return this.http.get<Teacher[]>('api/queries/Teacher/getDatabyType.php',{params:{type:type}})
  }
  getDatabyId(id:string):Observable<Teacher[]>{
    return this.http.get<Teacher[]>('api/queries/Teacher/getTeacher.php',{params:{id:id}})
  }



}
export interface  Teacher {
    idUser:string,
    name:string,
    lastname:string,
    email:string,Teacher
    type:string
    idExtension:string
}

export interface Response{
  success: boolean
}

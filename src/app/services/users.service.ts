import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ToasterService } from './toaster.service';

@Injectable({
  providedIn: 'root'
})
export class UsersService {

  constructor(private http: HttpClient) { }


  getData(): Observable<User[]>{
    return this.http.get<User[]>('api/queries/User/getData.php')
  }
  Search(ter:string,type:string): Observable<User[]>{
    ter = ter.toLowerCase()
    return this.http.get<User[]>('api/queries/User/searchData.php',{params:{ter: ter, type: type}})
  }
  Save(model) {
    return this.http.post('api/queries/User/saveUser.php',JSON.stringify(model))
  }
  Update(model,id) {
    return this.http.post('api/queries/User/updateUser.php',{model: JSON.stringify(model),id: id})
  }
  Delete(id:string){
    return this.http.post<Response>('api/queries/User/deleteData.php',id)
  }
  getUserbyType(type:string): Observable<User[]>{
    return this.http.get<User[]>('api/queries/User/getDatabyType.php',{params:{type:type}})
  }
  getDatabyId(id:string): Observable<User>{
    return this.http.get<User>('api/queries/User/getUser.php',{params:{id:id}})
  }
  // checkEmail(email){
  //   return this.http.post('api/queries/User/checkEmail.php',{email:email})
  // }
}

export interface  User {
    idUser:string,
    name:string,
    lastname:string,
    email:string,
    password:string,
    type:string
    idExtension:string
}

export interface Response{
  success: boolean
}

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class PorfileService {

  constructor(private http: HttpClient) { }

  getTeacherinfo():Observable<Teacher[]>{
    return this.http.get<Teacher[]>('api/queries/Teacher/getinfoporfile.php')
  }
  changePassTeacher(model){
    return this.http.post('api/queries/Teacher/changePassword.php',JSON.stringify(model))
  }
  changePorfile(model){
    return this.http.post('api/queries/Teacher/changePorfiledata.php',JSON.stringify(model))
  }

}

interface Teacher {
    code:string,
    name:string,
    lastname:string,
    email:string,
    extensionName:string
}

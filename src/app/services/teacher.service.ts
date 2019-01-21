import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class TeacherService {

  constructor(private http: HttpClient) { }

  // getSomeData(){
  //   return this.http.get<myData>('api/queries/Auth/validateUser.php')
  // }
  //
  // isLoggedIn(){
  //   return this.http.get<logged>('api/queries/Auth/isLoggedIn.php')
  // }
  changePassword(oldpassword, newpassword){
    return this.http.post('api/queries/Teacher/changePassword.php',{oldpassword: oldpassword, newpassword: newpassword})
  }
  updatePorfile(model){
    return this.http.post('api/queries/Teacher/updatePorfile.php',JSON.stringify(model))
  }
}
interface myData {
    message: string,
    success: boolean
}

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class UserService {
  url = 'http://localhost:1235/api/Queries/Auth/';
  constructor(private http: HttpClient) {}

  getSomeData(){
    return this.http.get<myData>('api/queries/Auth/validateUser.php')
  }

  getPorfile(): Observable<Porfile>{
    return this.http.get<Porfile>('api/queries/User/getPorfile.php')
  }

  changePassword(oldpassword, newpassword){
    return this.http.post('api/queries/User/changePassword.php',{oldpassword: oldpassword, newpassword: newpassword})
  }
  
  updatePorfile(model){
    return this.http.post('api/queries/User/updatePorfile.php',JSON.stringify(model))
  }
}

interface myData {
    message: string,
    success: boolean
}
interface logged{
  type: string,
  logged: boolean
}
interface userInfo{
  username:string,
  email:string,
  type:string
}
export interface Porfile{
  name: string,
  lastname: string,
  email: string,
  type: string,
  extensionName: string
}
interface isLoggedIn{
  status: boolean
}
interface logoutStatus{
  succes: boolean
}

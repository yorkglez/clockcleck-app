import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';


@Injectable({
  providedIn: 'root'
})
export class AuthService {
  url = 'http://localhost:1235/api/Queries/Auth/';
  private user:User;
  //private teacher:Teacher;
  private loggedInStatus = false
  constructor(private http:HttpClient) { }
  getUserDetails(user){
    return this.http.post<myData>('http://api.malastareas.com.mx/Auth/authTeacher.php',JSON.stringify(user))
  }

  /*Validate session data in db and return if this data exists*/
  authUser(user){
    return this.http.post<myData>('api/queries/Auth/authUser.php',JSON.stringify(user))
  }
  authTeacher(teacher){
    return this.http.post<myData>('api/queries/Auth/authTeacher.php',JSON.stringify(teacher))
  }
  logout(){
    return this.http.get<logout>('api/queries/Auth/logOut.php')
  }
  verifyToken(type:string, token:string, id:string, action:string){
    return this.http.post('api/queries/Auth/verifyToken.php',{type: type, token: token, id: id,action: action})
  }
  verifyEmail(email){
    return this.http.post('api/queries/Auth/verifyEmail.php',JSON.stringify(email))
  }
  resetPassword(email,type){
    return this.http.post('api/queries/Auth/resetPassword.php',{email: email, type: type})
  }
  changePassword(model){
    return this.http.post('api/queries/Auth/changePassword.php',JSON.stringify(model))
  }
  //create localStorage from user logged
  setLoggedIn(value: boolean){
    this.loggedInStatus = value
    // if (value) {
    //   if(type == 'normal'){
    //     localStorage.setItem('extension',extension)
    //   }
    //   localStorage.setItem('username',username)
    //   localStorage.setItem('email',email)
    // }
  }
  isLoggedIn(){
    return this.http.get<logged>('api/queries/Auth/isLoggedIn.php')
  }

  // get isLoggedIn(){
  //   return this.loggedInStatus
  // }
  /*Get user info*/
  getUserInfo(){
    return this.http.get('api/queries/Auth/getUserInfo.php');
  }
}
export interface User{
  email: string;
  password: string;
}
/*export interface Teacher{
  email: string;
  password: string;
}*/
export interface logout{
  success: boolean,
  type: string
}
interface logged{
  type: string,
  logged: boolean
}
interface myData {
    success: boolean,
    username?: string,
    email?: string,
    extension?: string,
    type?: string,
    message?: string
}

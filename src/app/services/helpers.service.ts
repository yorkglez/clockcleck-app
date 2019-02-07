import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class HelpersService {

  constructor(private http: HttpClient) { }

  validateEmail(email){
    return this.http.post<Validate>('api/queries/Helpers/checkEmail.php',email)
  }
  
  validateCode(code){
    return this.http.post<Validate>('api/queries/Helpers/validateCodeTeacher.php',JSON.stringify(code))
  }

  validateCodeSubject(code){
    return this.http.post<Validate>('api/queries/Helpers/validateCodeSubjectr.php',JSON.stringify(code))
  }

  validateCodeCarer(code){
    return this.http.post<Validate>('api/queries/Helpers/validateCodeCarer.php',JSON.stringify(code))
  }

  validateNameExtension(name){
    return this.http.post<Validate>('api/queries/Helpers/validateNameExtension.php',JSON.stringify(name))
  }

}
interface Validate{
  valid: boolean
}

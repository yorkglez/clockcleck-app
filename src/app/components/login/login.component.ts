import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';
import { UserService } from '../../services/user.service';
import { map } from 'rxjs/operators';
import { Title } from '@angular/platform-browser';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['../../../assets/css/loginStyles.css']
})
export class LoginComponent implements OnInit {
  model= {'email':'','password':''}
  isError: boolean = false
  constructor(private _authService: AuthService,
              private router: Router,
              private _userService: UserService,
              private _titleService: Title) {
                 this._titleService.setTitle('Iniciar sesion usuario')
              }

  ngOnInit(){
      /* call isLoggedIn service */
      this._authService.isLoggedIn().subscribe(resp=> {
      /* Validate if user is logged */
      if(resp.type == 'admin' && resp.logged)
        this.router.navigate(['users']) //redirect to users page
      else if(resp.type == 'normal' && resp.logged)
        this.router.navigate(['reports']) //redirect to reports page
      else if(resp.type == 'teacher' && resp.logged)
        this.router.navigate(['porfileteacher']) //redirect to porfileteacher page
      /* user isn't logged*/
      else{
        localStorage.clear() //Clear localstorage
        this.router.navigate(['login']) //redirect to login page
        localStorage.setItem('type','user') //Create session in localStorage
      }
    })
    this.model['email']  = ''
    this.model['password']  = ''
}

  loginUser(){
    /* Validate email and password */
    if(this.model['email'] !='' && this.model['password'] !='') {
      /* Call authUser service */
      this._authService.authUser(this.model).subscribe(resp => {
        /* Validate response*/
        if (resp.success) {
          /* Validate user type */
          if(resp.type == 'admin'){
            this.router.navigate(['users'])//Redirect to home admin
            this._authService.setLoggedIn(true)
          }
          else if(resp.type == 'normal'){
            this.router.navigate(['reports'])//Redirect to home user normal
            this._authService.setLoggedIn(true)
          }
          localStorage.clear();  //Clear localstorage
          /* Create localStorage with user data */
          localStorage.setItem('extension',resp.extension)
          localStorage.setItem('username',resp.username)
          localStorage.setItem('email',resp.email)
          localStorage.setItem('type',resp.type)
        }
        /* Login error */
        else{
          this._authService.setLoggedIn(false)
          this.isError = true
        }
      })
    }
  }

}

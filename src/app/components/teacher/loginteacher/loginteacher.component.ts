import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../../../services/auth.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-loginteacher',
  templateUrl: './loginteacher.component.html',
  styleUrls: ['../../../../assets/css/loginStyles.css']
})
export class LoginteacherComponent implements OnInit {
  model= {'email':'','password':''}
  error: boolean = false
  constructor(private _authService: AuthService,
              private router: Router,
              private _titleService: Title
              ) {
               this._titleService.setTitle('Iniciar sesion docente')
              }

  ngOnInit() {
    this._authService.isLoggedIn().subscribe(resp=> {
    if(resp.type == 'admin' && resp.logged)
      this.router.navigate(['users'])
    else if(resp.type == 'normal' && resp.logged)
      this.router.navigate(['reports'])
    else if(resp.type == 'teacher' && resp.logged)
      this.router.navigate(['porfileteacher'])
    else{
      localStorage.clear()
      this.router.navigate(['loginteacher'])
      localStorage.setItem('type','teacher')
    }
  })
    this.model['email']  = ''
    this.model['password']  = ''
  }

  loginUser(){
    if (this.model['email'] !='' && this.model['password'] !='') {
      this._authService.authTeacher(this.model).subscribe(resp => {

        if (resp.success) {
         this.router.navigate(['scheduleteacher'])//Redirect to home teacher
          this._authService.setLoggedIn(true)

          localStorage.clear();
          localStorage.setItem('username',resp.username)
          localStorage.setItem('email',resp.email)
          localStorage.setItem('type',resp.type)
          localStorage.setItem('extension',resp.extension)
          console.log(localStorage)
        }
        else{
          this._authService.setLoggedIn(false)
          this.error = true
        }
      })
    }
  }

}

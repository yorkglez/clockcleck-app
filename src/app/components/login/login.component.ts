import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';
import { UserService } from '../../services/user.service';
import { map } from 'rxjs/operators';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['../../../assets/css/loginStyles.css']
})
export class LoginComponent implements OnInit {
  model= {}
  isError: boolean = false
  constructor(private _authService: AuthService,
              private router: Router,
              private _userService: UserService) {}

  ngOnInit(){
      this._authService.isLoggedIn().subscribe(resp=> {
      if(resp.type == 'admin' && resp.logged)
        this.router.navigate(['users'])
      else if(resp.type == 'normal' && resp.logged)
        this.router.navigate(['reports'])
      else if(resp.type == 'teacher' && resp.logged)
        this.router.navigate(['porfileteacher'])
      else{
        localStorage.clear()
        this.router.navigate(['login'])
        localStorage.setItem('type','user')
      }
    })
    this.model['email']  = ''
    this.model['password']  = ''
}

loginUser(event){
  if (this.model['email'] !='' && this.model['password'] !='') {
    this._authService.authUser(this.model).subscribe(resp => {
      if (resp.success) {
        if(resp.type == 'admin'){
          this.router.navigate(['users'])//Redirect to home admin
          this._authService.setLoggedIn(true)
        }
        else if(resp.type == 'normal'){
          this.router.navigate(['reports'])//Redirect to home user normal
          this._authService.setLoggedIn(true)
        }
        localStorage.clear();
        localStorage.setItem('extension',resp.extension)
        localStorage.setItem('username',resp.username)
        localStorage.setItem('email',resp.email)
        localStorage.setItem('type',resp.type)
      }
      else{
        this._authService.setLoggedIn(false)
        this.isError = true
      }
    })
  }
}

}

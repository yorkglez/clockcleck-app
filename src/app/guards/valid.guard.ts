import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { AuthService } from '../services/auth.service';
import { Router } from '@angular/router';
import { map } from 'rxjs/operators';
import { ActivatedRoute } from '@angular/router';
import { UserService } from '../services/user.service';

@Injectable({
  providedIn: 'root'
})

export class ValidGuard implements CanActivate {
  response: boolean = false
  authData:any = []
  constructor(private _authService: AuthService,
              private _userService: UserService,
              private router: Router){
  }

  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ): Observable<boolean> | Promise<boolean> | boolean {
    /*validate forgotpassword route*/
    if(next.url[0].path  == 'forgotpassword'){
      /*Call function isLoggedIn from service*/
      return this._authService.isLoggedIn().pipe(map(resp=> {
        /* Validate if user not is logged*/
        if(!resp.logged){
          return true
        }
        else if(resp.type =='admin' && resp.logged){
          this.router.navigate(['users']) // rederect to users
          return false
        }
        else if(resp.type =='normal' && resp.logged){
          this.router.navigate(['reports']) // rederect to reports
          return false
        }
        else if(resp.type =='teacher' && resp.logged){
          this.router.navigate(['porfileteacher']) // rederect to porfile
          return false
        }
      }))
    }
    /*Validate reset routes*/
    else{
      /*get url params*/
      let type = next.params['type']
      let token = next.params['token']
      let id = next.params['id']
      let action = next.params['action']
      /*Call function isLoggedIn from service*/
      return this._authService.verifyToken(type,token, id, action).pipe(map(resp=> {
        if(resp && localStorage.length == 1)
        return true
        else if(localStorage.getItem('type') == 'admin'){
          this.router.navigate(['users']) // rederect to user
          return false
        }
        else if(localStorage.getItem('type') == 'normal'){
          this.router.navigate(['reports']) // rederect to reports
          return false
        }
        else if(localStorage.getItem('type') == 'teacher'){
          this.router.navigate(['porfileteacher']) // rederect to porfile
          return false
        }
        // return true
      }))
    }
  }
}

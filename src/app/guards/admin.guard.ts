import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { AuthService } from '../services/auth.service';
import { Router } from '@angular/router';
import { UserService } from '../services/user.service';
import { map } from 'rxjs/operators';
@Injectable({
  providedIn: 'root'
})
export class AdminGuard implements CanActivate {
  constructor(private _authService: AuthService,
              private router: Router,
              private _userService: UserService){

  }
  /**
   * [canActivate description]
   * @param  next  [description]
   * @param  state [description]
   * @return       [description]
   */
  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean {
    /*Call function isLoggedIn from service*/
    return this._authService.isLoggedIn().pipe(map(resp=> {
  /* Validate type user*/
      if(resp.type == 'admin' && resp.logged){
        this._authService.setLoggedIn(true); // users is logged
        return true
      }
      else if(resp.type == 'normal' && resp.logged && next.url[0].path  != 'reports'){
          this._authService.setLoggedIn(true); // users is logged
          this.router.navigate(['reports']) // rederect to reports
          return true
      }
      else if(resp.type == 'normal' && resp.logged && next.url[0].path  == 'reports'){
          this._authService.setLoggedIn(true); // users is logged
          return true
      }
      else if(resp.type == 'teacher' && resp.logged){
        this.router.navigate(['porfileteacher']) // rederect to porfile
        return false
      }
      else{
        this._authService.setLoggedIn(false); // users is logged
        this.router.navigate(['login']) // rederect to login
        localStorage.clear()
        return false
      }
    }))
  }
}

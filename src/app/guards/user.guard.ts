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
export class UserGuard implements CanActivate {
  constructor(private auth: AuthService,
              private router: Router,
              private _userService: UserService){
  }

  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean {
      /*Call function isLoggedIn from service*/
      return this.auth.isLoggedIn().pipe(map(resp=> {
        /* Validate type user*/
        if(resp.type == 'normal' && resp.logged){
          this.auth.setLoggedIn(true); // users is logged
          return true
        }
        else if(resp.type == 'admin' && resp.logged){
          this.auth.setLoggedIn(true); // users is logged
          return true
        }
        /* user type teacher*/
        else{
          this.router.navigate(['login']) // rederect to login
          localStorage.clear() //clear localStorage
          return false
        }
      }))
  }
}

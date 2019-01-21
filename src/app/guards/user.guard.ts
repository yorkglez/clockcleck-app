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


      return this.auth.isLoggedIn().pipe(map(resp=> {
        if(resp.type == 'normal' && resp.logged){
          this.auth.setLoggedIn(true);
          return true
        }
        else if(resp.type == 'admin' && resp.logged){
          this.auth.setLoggedIn(true);
          return true
        }
        else{
          this.router.navigate(['login'])
          localStorage.clear()
          return false
        }
      }))
  }
}

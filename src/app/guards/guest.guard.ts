import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { UserService } from '../services/user.service';
import { Router } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { map } from 'rxjs/operators';
@Injectable({
  providedIn: 'root'
})
export class GuestGuard implements CanActivate {
  constructor(private auth: AuthService,
              private router: Router,
              private _userService: UserService){

  }

  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean {
      return this.auth.isLoggedIn().pipe(map(resp=> {
        if(resp.type == 'admin' && resp.logged){
          this.router.navigate(['users'])
          return false
        }
        else if(resp.type == 'normal' && resp.logged){
            this.router.navigate(['reports'])
            return false
        }
        else if(resp.type == 'teacher' && resp.logged){
          this.router.navigate(['porfileteacher'])
          return false
        }
        else
          return true

      }))
  }
}

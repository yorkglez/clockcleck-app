import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { AuthService } from './services/auth.service';
import { Router } from '@angular/router';
import { UserService } from './services/user.service';
import { map } from 'rxjs/operators';
@Injectable({
  providedIn: 'root'
})
export class AuthGuard implements CanActivate {
  constructor(private auth: AuthService, private router: Router, private user: UserService){

  }
  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean {
      // return true
      if(this.auth.isLoggedIn) {
        return true
      }
      //validate if session users exists
      return this.auth.isLoggedIn().pipe(map(res=> {

        console.log(res)

        console.log(localStorage)
        // return true
        if(res){
          this.auth.setLoggedIn(true);
          return true
        }else{
          this.router.navigate(['login'])
          // location.reload()
          // localStorage.removeItem('email');
          // localStorage.removeItem('username');
          // localStorage.removeItem('username');
          localStorage.clear();
          return false
        }
      }))
    // if(!this.auth.isLoggedIn) {
    //   this.router.navigate(['login'])
    // }
    // return this.auth.isLoggedIn;
  }
}

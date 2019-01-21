import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { Observable } from 'rxjs';
import { map } from 'rxjs/operators';
import { AuthService } from '../services/auth.service';
import { Router } from '@angular/router';
import { TeacherService } from '../services/teacher.service';
@Injectable({
  providedIn: 'root'
})
export class TeacherGuard implements CanActivate {

  constructor(private _authService: AuthService,
              private router: Router,
              private _teacherService: TeacherService){

  }
  canActivate(
    next: ActivatedRouteSnapshot,
    state: RouterStateSnapshot): Observable<boolean> | Promise<boolean> | boolean {

    return this._authService.isLoggedIn().pipe(map(resp=> {
      if(resp.type == 'teacher' && resp.logged){
        this._authService.setLoggedIn(true);
        return true
      }
      else if(resp.type == 'admin' && resp.logged){
        this.router.navigate(['users'])
        return false
      }
      else if(resp.type == 'normal' && resp.logged){
        this.router.navigate(['reports'])
        return false
      }
      else{
        this.router.navigate(['loginteacher'])
        return false
      }
    }))
  }
}

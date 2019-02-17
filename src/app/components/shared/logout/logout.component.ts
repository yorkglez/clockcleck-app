import { Component, OnInit } from '@angular/core';
import { UserService } from '../../../services/user.service';
import { Router } from '@angular/router';
import { AuthService } from '../../../services/auth.service';

@Component({
  selector: 'app-logout',
  template: '',
  styles: []
})
export class LogoutComponent implements OnInit {

  constructor(private user: UserService,
     private router: Router,
     private _authService: AuthService)
     { }

     ngOnInit() {
       this._authService.logout().subscribe(resp => {
         if(resp.success){
           this._authService.setLoggedIn(false)
           localStorage.clear()
           if(resp.type =='teacher')
           this.router.navigate(['/loginteacher'])
           if(resp.type =='user')
           this.router.navigate(['/login'])
         }
         else
         window.alert('Some problem')
       })
     }

}

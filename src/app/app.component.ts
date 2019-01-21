import { Component, OnInit } from '@angular/core';
import { AuthService } from './services/auth.service';
import { Router } from '@angular/router';
import {
  trigger,
  state,
  style,
  animate,
  transition,
} from '@angular/animations';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css','../assets/css/sidebarStyles.css']
 //  animations: [
 //   // animation triggers go here
 // ]
})
export class AppComponent  implements OnInit {
  title = 'app';
  showSidebar: boolean = false
  sidebar: boolean = false
  username:string
  admin: boolean = false
  constructor(private _authService: AuthService, private router: Router){

  }
  onActivate() {
    // console.log(localStorage)
    this.username = localStorage.getItem('username')
    let type = localStorage.getItem('type')
    // console.log(type)
    if(type == 'admin' || type == 'normal')
      this.sidebar = true
    else
      this.sidebar = false
    if(type == 'admin')
      this.admin = true
  }
  ngOnInit(){

      //     $(window).on('scroll',function(){
      //   if($(window).scrollTop()){
      //     $('header').addClass('nav-scroll');
      //     $('.side').addClass('side-scroll');
      //     $('.side').removeClass('side-sticky');
      //   }else{
      //     $('header').removeClass('nav-scroll');
      //     $('.side').removeClass('side-scroll');
      //     $('.side').addClass('side-sticky');
      //   }
      // });
  }
  toggledSidebar(){
    if(this.showSidebar)
      this.showSidebar = false;
    else
      this.showSidebar = true
  }
  logout(){
      this._authService.logout().subscribe(resp=>{
        if(resp){
          this.showSidebar = false
          this.sidebar = false

          let type = localStorage.getItem('type')
          if(type == 'admin' || type == 'normal')
            this.router.navigate(['/login'])
          else
            this.router.navigate(['/loginteacher'])
          localStorage.clear()
          this._authService.setLoggedIn(false)
        }
      })

  }
}

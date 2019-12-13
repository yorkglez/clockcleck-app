import { Component, OnInit } from '@angular/core';
import { Title }     from '@angular/platform-browser';
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
  styleUrls: ['./app.component.css',
  '../assets/css/sidebarStyles.css']
 //  animations: [
 //   // animation triggers go here
 // ]
})
export class AppComponent  implements OnInit {
  title = 'app';
  username:string
  type:string = ''
  showSidebar: boolean = false
  sidebar: boolean = false
  admin: boolean = false
  date = new Date()
  constructor(private _authService: AuthService,
              private _titleService: Title,
              private router: Router){

  }

  public setTitle( newTitle: string) {
    this._titleService.setTitle( newTitle );
  }

  onActivate() {

  //  this.title = 'hello World!'
    // console.log(localStorage)

    this.username = localStorage.getItem('username')
    this.type = localStorage.getItem('type')

   //console.log(this.type)
    if(this.type == 'admin' || this.type == 'normal'){
      this.admin = true
      this.sidebar = true
    }
  //    this.sidebar = true
    else
      this.sidebar = false
//    if(type == 'admin')
  //    this.admin = true
    // this.sidebar = true
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

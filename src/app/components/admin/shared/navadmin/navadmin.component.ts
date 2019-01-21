import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../../../services/auth.service';

@Component({
  selector: 'app-navadmin',
  templateUrl: './navadmin.component.html',
  styleUrls: ['../../../../../assets/css/navbarStyles.css']
})
export class NavadminComponent implements OnInit {
  username: string
  constructor(private _authService: AuthService) { }

  ngOnInit() {
    // this._authService.getUserInfo().subscribe(data=>{
    //   console.log(data)
    // })
    // console.log(localStorage.username)
    // this.username = localStorage.username
  }

}

import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../../services/auth.service';
import {Title} from "@angular/platform-browser";
@Component({
  selector: 'app-resetpassword',
  templateUrl: './resetpassword.component.html',
  styleUrls: ['../../../../assets/css/confirmEmailStyles.css']
})
export class ResetpasswordComponent implements OnInit {
  model = {}
  emailValid: boolean = false
  type:string = 'user'
  comfirmComple: boolean = false
  alertPass: boolean = false
  passwordsisValid: boolean = true
  constructor(private _authService: AuthService, private titleService: Title) {

  }

  ngOnInit() {
    this.titleService.setTitle('Nueva contraseña')
  }
  validatePasswords(password, repeatpassword){
    if(password == repeatpassword){
      this.passwordsisValid = true
    }
    else{
      this.passwordsisValid = false
    }
  }

}

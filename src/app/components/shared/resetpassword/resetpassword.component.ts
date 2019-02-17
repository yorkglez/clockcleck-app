import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../../services/auth.service';
import {Title} from "@angular/platform-browser";
import { ActivatedRoute } from '@angular/router';
import { HttpClient } from '@angular/common/http';
@Component({
  selector: 'app-resetpassword',
  templateUrl: './resetpassword.component.html',
  styleUrls: ['../../../../assets/css/confirmEmailStyles.css']
})
export class ResetpasswordComponent implements OnInit {
  id:string
  type:string
  token: string
  action: string
  url:string
  model = {}
  emailValid: boolean = false
  //type:string = 'user'
  comfirmComple: boolean = false
  alertPass: boolean = false
  passwordsisValid: boolean = true
  constructor(private activatedRoute:ActivatedRoute,
              private _authService: AuthService,
              private titleService: Title) {
  }

  ngOnInit() {
    this.titleService.setTitle('Restablecer contraseña')
    this.activatedRoute.params.subscribe( params =>{
      this.id = params['id']
      this.type = params['type']
      this.token = params['token']
      this.action = params['action']
    })
  }

  validatePasswords(password, repeatpassword){
    if(password == repeatpassword)
      this.passwordsisValid = true
    else
      this.passwordsisValid = false
  }

  changePassword(){
    this.model['id'] = this.id
    this.model['type'] = this.type
    this.model['token'] = this.token
    this.model['action'] = this.action
    if(this.passwordsisValid){
      this._authService.changePassword(this.model).subscribe(resp=>{
        if(resp){
            this.comfirmComple = true
            if(this.type == 'user')
              this.url = '/login'
            else
              this.url = '/loginteacher'
        }
      })
    }
  }

}

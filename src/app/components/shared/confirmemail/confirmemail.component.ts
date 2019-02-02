import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { AuthService } from '../../../services/auth.service';
import { ActivatedRoute } from '@angular/router';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-confirmemail',
  templateUrl: './confirmemail.component.html',
  styleUrls: ['../../../../assets/css/confirmEmailStyles.css',
  '../../../../assets/css/panelStyles.css'
  ]
})
export class ConfirmemailComponent implements OnInit {
  id:string
  type:string
  token: string
  model = {}
  passwordsValid: boolean = true
  comfirmComple: boolean = false
  constructor(private activatedRoute:ActivatedRoute,
              private http: HttpClient,
              private _authService: AuthService) { }

  ngOnInit() {
    this.activatedRoute.params.subscribe( params =>{
      this.id = params['id']
      this.type = params['type']
      this.token = params['token']
    })
  }

  validatePasswords(password, repeatpassword){
    if(password == repeatpassword)
      this.passwordsValid = true
    else
      this.passwordsValid = false
  }

  changePassword(){
    this.model['id'] = this.id
    this.model['type'] = this.type
    this.model['token'] = this.token
    if(this.passwordsValid){
      this._authService.changePassword(this.model).subscribe(resp=>{
        if(resp)
          this.comfirmComple = true
      })
    }
  }
}

import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { AuthService } from '../../../services/auth.service';
import { ActivatedRoute } from '@angular/router';
import { NgForm } from '@angular/forms';
import { Title } from '@angular/platform-browser';

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
  url: string
  action: string
  model = {}
  passwordsValid: boolean = true
  comfirmComple: boolean = false
  constructor(private activatedRoute:ActivatedRoute,
              private http: HttpClient,
              private _authService: AuthService,
              private titleService: Title) { }

  ngOnInit() {
    this.titleService.setTitle('Confirmar email') //set Title page
    /*Get url params*/
    this.activatedRoute.params.subscribe( params =>{
      this.id = params['id']
      this.type = params['type']
      this.token = params['token']
      this.action = params['action']
    })
  }

  validatePasswords(password, repeatpassword){
    /*Compare passwords*/
    if(password == repeatpassword)
      this.passwordsValid = true
    else
      this.passwordsValid = false
  }

  changePassword(){
    /*add data to model*/
    this.model['id'] = this.id
    this.model['type'] = this.type
    this.model['token'] = this.token
    this.model['action'] = this.action
    /*Validate password*/
    if(this.passwordsValid){
      /*Call function changePassword from service*/
      this._authService.changePassword(this.model).subscribe(resp=>{
        if(resp){
          this.comfirmComple = true //show complete message
          if(this.type == 'user')
            this.url = '/login'
          else
            this.url = '/loginteacher'

        }

      })
    }
  }
}

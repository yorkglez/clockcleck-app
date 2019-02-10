import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../../services/auth.service';
import { HelpersService } from '../../../services/helpers.service';

@Component({
  selector: 'app-forgotpassword',
  templateUrl: './forgotpassword.component.html',
  styleUrls: ['../../../../assets/css/confirmEmailStyles.css']
})
export class ForgotpasswordComponent implements OnInit {

  model = {}
  emailisValid: boolean = false
  type:string = localStorage.getItem('type')
  confirmisComple: boolean = false
  url:string

  constructor(private _authService: AuthService,
  private _helpersService: HelpersService) { }

  ngOnInit() {
    console.log(this.type)
  }

  validateEmail(email){
    /*Validate email*/
    if(email.valid){
      /*Call function validateEmail from service*/
      this._helpersService.validateEmail(email.value).subscribe(resp =>{
        if(resp)
          this.emailisValid = true
        else
          this.emailisValid = false
      })
    }
  }

  sendReset(email){
    /*Validate email*/
    if(this.emailisValid){
      /*Call function resetPassword from service*/
      this._authService.resetPassword(this.model['email'],this.type).subscribe(resp=>{
        /*Validate response*/
        if(resp){
          this.confirmisComple = true
          /*Verify user type*/
          if(this.type = 'user')
            this.url = '/login' //generate login url
          else
            this.url = '/loginteacher' //generate login url
        }
      })
    }
  }

}

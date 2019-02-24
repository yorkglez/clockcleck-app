import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../../services/auth.service';
import { UserService ,Porfile } from '../../../services/user.service';
import { HelpersService } from '../../../services/helpers.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-porfile',
  templateUrl: './porfile.component.html',
  styleUrls: [
              '../../../../assets/css/panelStyles.css',
            '../../../../assets/css/porfileStyles.css',
            '../../../../assets/css/containerStyles.css']
})
export class PorfileComponent implements OnInit {
  porfileInfo: any = []
  emailisValid: boolean = true
  isEditable: boolean = false
  passwordsisValid: boolean = true
  changePass: boolean = false
  alertisVisible: boolean = false
  type: string
  message: string
  model = {}
  data = {}

  constructor(private _authService: AuthService,
    private _userService: UserService,
    private _helpersService: HelpersService,
    private _titleService: Title) {
      this._titleService.setTitle('Perfil')
    }

  ngOnInit() {
    /*Call function getPorfile from service*/
    this._userService.getPorfile().subscribe(data=>{
      this.porfileInfo = data //get data
    })
  }

  validateEmail(email){
    let oldEmail = this.porfileInfo.email
    if(oldEmail != email){
      this._helpersService.validateEmail(email).subscribe(
        resp=>{
          if(resp)
            this.emailisValid = true
          else
            this.emailisValid = false
        })
    }
    else
      this.emailisValid = true
  }

  saveChanges(){
    if (this.emailisValid) {
      this._userService.updatePorfile(this.data).subscribe(resp=>{
        if(resp){
          this.type  = "success"
          this.message = 'Tus datos han sido actualizados.'
          this._userService.getPorfile().subscribe(data=>{
            this.porfileInfo = data
          })
        }
        else{
          this.type  = "error"
          this.message = 'Error al actualidar tus datos.'
        }
        this.isEditable = false
        this.alertisVisible = true
        setTimeout(() => {
        this.alertisVisible = false
        }, 2500)
      })
    }
  }

  editPorfile(){
    /*Validate editable status*/
    if(this.isEditable)
      this.isEditable = false //hide edit form
    else{
      this.isEditable = true //show edit form
      /*add data to form*/
      this.data['name'] = this.porfileInfo.name
      this.data['lastname'] = this.porfileInfo.lastname
      this.data['email'] = this.porfileInfo.email
    }
  }

  validatePasswords(password, repeatpassword){
    /*Validate passwords*/
    if(password == repeatpassword)
      this.passwordsisValid = true
    else
      this.passwordsisValid = false
  }

  showChangePass(){
    /* Show change password form*/
    if(this.changePass)
      this.changePass = false
    else
      this.changePass = true
  }

  changePassword(oldpassword, newpassword){
    /*compare passwords*/
    if (this.passwordsisValid && oldpassword != newpassword) {
      /*Call function changePassword from service*/
      this._userService.changePassword(oldpassword, newpassword).subscribe(resp=>{
        if(resp){
          this.changePass = false
          this.type  = "success"//alert type
          this.message = 'Su contrasena ha sido actualizada.'//alert message
        }
        else{
          this.type  = "error"//alert type
          this.message = 'La contrasena que escribiste no coincide con tu contrasena actual.'//alert message
        }
        this.alertisVisible = true //shhow alert]
        //hide alert in 2 secunds
        setTimeout(() => {
        this.alertisVisible = false //hide alert
        }, 2500)
      })
    }
  }

}

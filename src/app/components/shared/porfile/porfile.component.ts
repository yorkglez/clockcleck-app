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
            '../../../../assets/css/porfileStyles.css']
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
    this._userService.getPorfile().subscribe(data=>{
      this.porfileInfo = data
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
    if(this.isEditable)
      this.isEditable = false
    else{
      this.isEditable = true
      this.data['name'] = this.porfileInfo.name
      this.data['lastname'] = this.porfileInfo.lastname
      this.data['email'] = this.porfileInfo.email
    }
  }

  validatePasswords(password, repeatpassword){
    if(password == repeatpassword)
      this.passwordsisValid = true
    else
      this.passwordsisValid = false
  }

  showChangePass(){
    if(this.changePass)
      this.changePass = false
    else
      this.changePass = true
  }
  changePassword(oldpassword, newpassword){
    if (this.passwordsisValid && oldpassword != newpassword) {
      this._userService.changePassword(oldpassword, newpassword).subscribe(resp=>{
        if(resp){
          this.changePass = false
          this.type  = "success"
          this.message = 'Su contrasena ha sido actualizada.'
        }
        else{
          this.type  = "error"
          this.message = 'La contrasena que escribiste no coincide con tu contrasena actual.'
        }
        this.alertisVisible = true
        setTimeout(() => {
        this.alertisVisible = false
        }, 2500)
      })
    }
    else{

    }
  }

}

import { Component, OnInit } from '@angular/core';
import { PorfileService } from '../../../services/porfile.service';
import { HelpersService } from '../../../services/helpers.service';
import { TeacherService } from '../../../services/teacher.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-porfile-teacher',
  templateUrl: './porfile-teacher.component.html',
  styleUrls: ['../../../../assets/css/porfileStyles.css',
'../../../../assets/css/panelStyles.css']
})
export class PorfileTeacherComponent implements OnInit {
  porfileInfo:any = []
  model = {}
  data = {}
  changePass: boolean = false
  isEditable: boolean = false
  passwordsisValid: boolean = true
  emailisValid: boolean = true
  alertisVisible: boolean = false
  type: string
  message: string
  constructor(private _porfileService: PorfileService,
              private _helpersService: HelpersService,
              private _teacherService: TeacherService,
              private _titleService: Title
            ) {
              this._titleService.setTitle('Perfil')
            }

  ngOnInit() {
    this.getPorfileInfo()
  }

  getPorfileInfo(){
    this._porfileService.getTeacherinfo().subscribe(data=>{
      this.porfileInfo = data
      // this.data['lastname'] = data.lastname
      // this.data['name'] = data.name
      // this.data['email'] = data.email
    })
  }
  showChangePass(){
    this.changePass = true
  }

  changePassword(oldpassword, newpassword){
    if (this.passwordsisValid && oldpassword != newpassword) {
      this._teacherService.changePassword(oldpassword, newpassword).subscribe(resp=>{
        if(resp){
          this.changePass = false
          this.type  = "success"
          this.message = 'Su contrasena ha sido actualizada'
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
  }
  saveChanges(){
    if (this.emailisValid) {
      this._teacherService.updatePorfile(this.data).subscribe(resp=>{
        if(resp){
          this.type  = "success"
          this.message = 'Tus datos han sido actualizados.'
          this._porfileService.getTeacherinfo  ().subscribe(data=>{
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
  validatePhone(phone){
    if(phone.length == 3 || phone.length == 7 )
      this.data['phone'] = phone + '-'
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
  editPorfile(){
    if(this.isEditable)
      this.isEditable = false
    else{
      this.isEditable = true
      this.data['name'] = this.porfileInfo.name
      this.data['lastname'] = this.porfileInfo.lastname
      this.data['email'] = this.porfileInfo.email
      this.data['phone'] = this.porfileInfo.phone

    }
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

import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { UsersService } from '../../../../services/users.service';
import { NgForm } from '@angular/forms';
import { ExtensionsService } from '../../../../services/extensions.service';
import { HelpersService } from '../../../../services/helpers.service';
import { Title } from '@angular/platform-browser';
@Component({
  selector: 'app-create-user',
  templateUrl: './create-user.component.html',
  styleUrls: [  '../../../../../assets/css/panelStyles.css']
})
export class CreateUserComponent implements OnInit {
  model = {}
  extensions: any[];
  passwordsValid: boolean = true
  emailValid: boolean = true
  alertVisible: boolean = false
  type: string
  message: string
  constructor(private http: HttpClient,
              private _usersService: UsersService,
              private _extensionsService: ExtensionsService,
              private _helpersService: HelpersService,
              private _titleService: Title) {
                this._titleService.setTitle('Nuevo usuario')
      }

  ngOnInit() {
    this._extensionsService.getExtension().subscribe(data=>{this.extensions = data})
    this.model['type'] = 'normal'
    this.model['extension'] = localStorage.getItem('extension')
    this.model['genere'] = 'H'
  }

  // validatePasswords(password, repeatpassword){
  //   if(password == repeatpassword){
  //     this.passwordsValid = true
  //   }
  //   else{
  //     this.passwordsValid = false
  //   }
  // }
  validateEmail(email){
    this._helpersService.validateEmail(email).subscribe(resp =>{
      if(!resp){
        this.emailValid = true
      }else{
        this.emailValid = false
      }
    })
  }
  saveUser(form: NgForm){
     this._usersService.Save(this.model).subscribe(resp =>{
       if(resp){
         form.resetForm()
          this.type  = "success"
          this.message = 'El usuario se ha guardado correctamente.'
       }
       else{
         this.type  = "error"
         this.message = 'Ocurrio un error al gurdar.'
       }
       this.alertVisible = true
       setTimeout(() => {
       this.alertVisible = false
       }, 2500)
     })
  }
}

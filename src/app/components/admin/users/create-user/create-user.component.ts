import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { UsersService, newUser } from '../../../../services/users.service';
import { NgForm } from '@angular/forms';
import { ExtensionsService } from '../../../../services/extensions.service';
import { HelpersService } from '../../../../services/helpers.service';
import { Title } from '@angular/platform-browser';
@Component({
  selector: 'app-create-user',
  templateUrl: './create-user.component.html',
  styleUrls: [  '../../../../../assets/css/panelStyles.css',
  '../../../../../assets/css/containerStyles.css']
})
export class CreateUserComponent implements OnInit {
  model = {'name': '','lastname': '','email': '','type':'','extension':'','genere':''}
  extensions: any[];
  // passwordsValid: boolean = true
  emaiisValid: boolean = true
  alertisVisible: boolean = false
  types: string
  message: string
  constructor(private http: HttpClient,
              private _usersService: UsersService,
              private _extensionsService: ExtensionsService,
              private _helpersService: HelpersService,
              private _titleService: Title) {
                this._titleService.setTitle('Nuevo usuario')
      }

  ngOnInit() {
    /* call function getExtension from service*/
    this._extensionsService.getExtension().subscribe(data=>{this.extensions = data})
    this.model['type'] = 'normal' //set user type default
    this.model['extension'] = localStorage.getItem('extension') // set admin extension
    this.model['genere'] = 'H' //set genere default
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
    if(email.valid){
      /* Call function validaEmail from services */
      this._helpersService.validateEmail(email.value).subscribe(resp =>{
        /*Validate response*/
        if(!resp)
          this.emaiisValid = true // email is invalid
        else
          this.emaiisValid = false //email is valid
      })
    }
  }
  Save(form: NgForm){
     this._usersService.Save(this.model).subscribe(resp =>{
       if(resp){
         form.resetForm()
          this.types  = "success"
          this.message = 'El usuario se ha guardado correctamente.'
       }
       else{
         this.types  = "error"
         this.message = 'Ocurrió un error al guardar.'
       }
       this.alertisVisible = true
       setTimeout(() => {
       this.alertisVisible = false
       }, 2500)
     })
  }
}

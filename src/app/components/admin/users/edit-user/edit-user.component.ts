import { Component, OnInit } from '@angular/core';
import { ExtensionsService } from '../../../../services/extensions.service';
import { ActivatedRoute } from '@angular/router';
import { UsersService, User } from '../../../../services/users.service';
import { NgForm } from '@angular/forms';
import { FormBuilder, FormGroup, Validators   } from '@angular/forms';
import { FormControl } from '@angular/forms';
import { Router } from '@angular/router';
import { Title } from '@angular/platform-browser';
import { HelpersService } from '../../../../services/helpers.service';

@Component({
  selector: 'app-edit-user',
  templateUrl: './edit-user.component.html',
  styleUrls: [  '../../../../../assets/css/panelStyles.css',
  '../../../../../assets/css/containerStyles.css']
})
export class EditUserComponent implements OnInit {
  extensions = []
  model = {'name': '','lastname': '','email': '','type':'','extension':'','genere':''}
  id:string
  oldEmail:string
  passwordsValid: boolean = true
  emaiisValid: boolean = true
  alertVisible: boolean = false
  type: string
  message: string
  constructor(
              private _extensionsService: ExtensionsService,
              private activatedRoute:ActivatedRoute,
              private _usersService: UsersService,
              private router: Router,
              private _helpersService: HelpersService,
              private _titleService: Title) {
                this._titleService.setTitle('Editar usuario')
              }

  ngOnInit() {
    this._extensionsService.getExtension().subscribe(data=>{this.extensions = data}) //Get extensions list
    /* get urls params*/
    this.activatedRoute.params.subscribe( params => {
      this.id = params['id'] //get id
      /* Call function getDatabyId from service*/
      this._usersService.getDatabyId(this.id).subscribe(data=>{
         /*set data user in from*/
         this.model['name'] =  data.name
         this.model['lastname'] =  data.lastname
         this.model['email'] = data.email
         this.model['type'] =  data.type
         this.model['extension'] = data['Extensions_idExtension']
         this.model['genere'] = data['genere']
         this.oldEmail = data.email //get old email
      })
    })
  }
  validateEmail(email){
    /* Call function validaEmail from services */
    if(this.oldEmail != email){
      this._helpersService.validateEmail(email).subscribe(resp =>{
        /*Validate response*/
        if(!resp)
          this.emaiisValid = true // email is invalid
        else
          this.emaiisValid = false //email is valid
      })
    }
    else
      this.emaiisValid = true
  }
  Update(model){
    this._usersService.Update(model,this.id).subscribe(resp=>{
      if(resp){
        this.router.navigate(['/users'])
      }

    })
  }
}

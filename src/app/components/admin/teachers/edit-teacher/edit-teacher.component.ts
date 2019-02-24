import { Component, OnInit } from '@angular/core';
import { ExtensionsService } from '../../../../services/extensions.service';
import { ActivatedRoute } from '@angular/router';
import { Router } from '@angular/router';
import { TeachersService } from '../../../../services/teachers.service';
import { NgForm } from '@angular/forms';
import { HelpersService } from '../../../../services/helpers.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-edit-teacher',
  templateUrl: './edit-teacher.component.html',
    styleUrls: [  '../../../../../assets/css/panelStyles.css',
    '../../../../../assets/css/containerStyles.css']
})
export class EditTeacherComponent implements OnInit {
  extensions = []
  model = {'name':'','lastname':'','email':'','code':'','phone':'','type':'','extension':''}
  data = {}
  id:string;
  oldEmail:string
  emailValid: boolean = true
  codeValid: boolean = true
  constructor(private _extensionsService: ExtensionsService,
              private _teachersService: TeachersService,
              private activatedRoute:ActivatedRoute,
              private _helpersService: HelpersService,
              private router: Router,
              private _titleService: Title) {
                this._titleService.setTitle('Editar docente')
              }

  ngOnInit() {
    this._extensionsService.getExtension().subscribe(data=>{this.extensions = data})//Get extensions list
    /* get urls params*/
    this.activatedRoute.params.subscribe( params => {
      this.id = params['id']
      /* Call function getDatabyId from service*/
      this._teachersService.getDatabyId(this.id).subscribe(data=>{
        this.oldEmail = data['email']
        this.model['code'] = data['codeTeacher']
        this.model['name'] = data['name']
        this.model['lastname'] = data['lastname']
        this.model['email'] = data['email']
        this.model['phone'] = data['phone']
        this.model['extension'] = data['idExtension']
        this.model['type'] = data['type']
      })
    })
  }
  Save(form: NgForm){
   if(this.emailValid && form.valid){
     this._teachersService.Update(this.model,this.id).subscribe(res => console.log(res))
     this.router.navigate(['/teachers'])
   }
  }

  validatePhone(phone){
    /* Validate phone length*/
    if(phone.length == 3 || phone.length == 7 )
      this.model['phone'] = phone + '-' //add character
  }

  validateCode(code){
    let  regex = /[0-9]|\./;
    if (regex.test(code)) {
      if(code != this.id){
        this._helpersService.validateCode(code).subscribe(resp=>{
          console.log(resp)
          if(!resp)
            this.codeValid = true
          else
            this.codeValid = false
        })
      }
    }
    else
      this.codeValid = true;
  }
  validateEmail(email){
    if(email != this.oldEmail){
      let regexp = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
      if(regexp.test(email)){
        this.data['email'] = email
        this.data['code'] = this.model['code']
        this._helpersService.validateEmail(this.data).subscribe(
          resp=>{
            if(!resp)
              this.emailValid = false
            else
              this.emailValid = true
          })
      }
      else
        this.emailValid = false
    }
    else
      this.emailValid = true


  }

}

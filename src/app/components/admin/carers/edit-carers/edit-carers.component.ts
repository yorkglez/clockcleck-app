import { Component, OnInit } from '@angular/core';
import { ExtensionsService } from '../../../../services/extensions.service';
import { ActivatedRoute } from '@angular/router';
import { CarersService } from '../../../../services/carers.service';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { HelpersService } from '../../../../services/helpers.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-edit-carers',
  templateUrl: './edit-carers.component.html',
  styleUrls: ['../../../../../assets/css/panelStyles.css',
  '../../../../../assets/css/containerStyles.css']
})
export class EditCarersComponent implements OnInit {
  extensions = []
  model = {"code": '','name':'','alias':'','extension':''}
  id:string;
  codeValid: boolean = true
  constructor(private _extensionsService: ExtensionsService,
              private activatedRoute:ActivatedRoute,
              private _carersService: CarersService,
              private _helpersService: HelpersService,
              private router: Router,
              private _titleService: Title) {
                this._titleService.setTitle('Editar carrera')
               }

 ngOnInit() {
   this._extensionsService.getExtension().subscribe(data=>{this.extensions = data}) //get extensions list
   /* call function params from service */
   this.activatedRoute.params.subscribe( params => {
     this.id = params['id'] //get id from  url param
     /* call getDatabyId function from service */
     this._carersService.getDatabyId(this.id).subscribe(data=>{
       /*add carer data to model*/
       this.model['code'] = data['codeCarer']
       this.model['name'] = data['name']
       this.model['alias'] = data['alias']
       this.model['extension'] = data['Extensions_idExtension']
     })
   })
 }
  addCharacter(code){
    if(code.length == 4 || code.length == 9 )
      this.model['code'] = code + '-'
  }
  validateCode(code){
    if (this.id != code.value && code.valid) {
        this._helpersService.validateCodeCarer(code).subscribe(resp=>{
          if(resp)
            this.codeValid = true
          else
            this.codeValid = false
        })
    }
  }

  Update(){
    /*Call function Update from service*/
    this._carersService.Update(this.model,this.id).subscribe(resp =>{
      /* Validate response*/
      if(resp)
      this.router.navigate(['/carers']) //redirect to carers
    })
  }

}

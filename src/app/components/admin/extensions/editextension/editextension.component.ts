import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Router } from '@angular/router';
import { ExtensionsService } from '../../../../services/extensions.service';
import { NgForm } from '@angular/forms';
import { HelpersService } from '../../../../services/helpers.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-editextension',
  templateUrl: './editextension.component.html',
  styleUrls: ['../../../../../assets/css/panelStyles.css']
})
export class EditextensionComponent implements OnInit {
  id: string
  name: string
  model = {}
  nameValid: boolean = true

  constructor(private _extensionsService: ExtensionsService,
              private activatedRoute:ActivatedRoute,
              private _helpersService: HelpersService,
              private router: Router,
              private _titleService: Title) {
                this._titleService.setTitle('Editar extension')
              }

  ngOnInit() {
    /* call function params from service */
    this.activatedRoute.params.subscribe( params => {
      this.id = params['id'] //get id from  url param
      /* call getDatabyId function from service */
      this._extensionsService.getDatabyId(this.id).subscribe(data=>{
        this.name = data.name
        /*add extension data to model*/
        this.model['name'] = data.name
        this.model['city'] = data.city
        this.model['address'] = data.address
      })
    })
  }

  validateName(name){
    if(name != this.name ){
      this._helpersService.validateNameExtension(name).subscribe(resp=>{
        if(resp)
          this.nameValid = true
        else
          this.nameValid = false
      })
    }
  }
  saveExtension(form: NgForm){
    if(this.nameValid){
      this.model['id'] = this.id
      this._extensionsService.Update(this.model).subscribe(resp =>{
        if(resp)
          this.router.navigate(['/extensions'])
      })
    }
  }
}

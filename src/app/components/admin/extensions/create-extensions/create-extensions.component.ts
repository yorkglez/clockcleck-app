import { Component, OnInit } from '@angular/core';
import { ExtensionsService } from '../../../../services/extensions.service';
import { HttpClient } from '@angular/common/http';
import { NgForm } from '@angular/forms';
import { HelpersService } from '../../../../services/helpers.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-create-extensions',
  templateUrl: './create-extensions.component.html',
  styleUrls: ['../../../../../assets/css/panelStyles.css',
  '../../../../../assets/css/containerStyles.css']
})
export class CreateExtensionsComponent implements OnInit {
  model = {'name':'','city':'','address':''}
  alertVisible: boolean = false
  nameValid: boolean = true
  type: string
  message: string

  constructor(
              private _extensionsService: ExtensionsService,
              private _helpersService: HelpersService,
              private _titleService: Title) {
                this._titleService.setTitle('Nueva extension')
              }

  ngOnInit() {

  }

  validateName(name){
    /* Call function validateNameExtension from service */
    this._helpersService.validateNameExtension(name).subscribe(resp=>{
      /*Validate response*/
      if(resp)
        this.nameValid = true
      else
        this.nameValid = false
    })
  }

  saveExtension(form: NgForm){
    if(this.nameValid){
      this._extensionsService.saveExtension(this.model).subscribe(resp =>{
        if(resp){
           form.resetForm()
           this.type  = "success"
           this.message = 'La extension se ha guardado correctamente.'
        }
        else{
          this.type  = "error"
          this.message = 'Ocurrio un error al guardar.'
        }
        this.alertVisible = true
        setTimeout(() => {
        this.alertVisible = false
        }, 2500)
      })
    }

  }
}

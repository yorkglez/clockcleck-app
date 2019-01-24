import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { ExtensionsService } from '../../../../services/extensions.service';
import { CarersService } from '../../../../services/carers.service';
import { HelpersService } from '../../../../services/helpers.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-create-carers',
  templateUrl: './create-carers.component.html',
  styleUrls: ['../../../../../assets/css/panelStyles.css']

})
export class CreateCarersComponent implements OnInit {
  model = {"code": ''}
  extensions: any[]
  codeValid: boolean = true
  alertVisible: boolean = false
  type: string
  message: string
  constructor(private http: HttpClient,
              private _carersService: CarersService,
              private _extensionsService: ExtensionsService,
              private _helpersService: HelpersService,
              private _titleService: Title) {
                this._titleService.setTitle('Nueva carrera')
              }

  ngOnInit() {
    this._extensionsService.getExtension().subscribe(data=>{this.extensions = data})
    this.model['extension'] = localStorage.getItem('extension')
  }

  Save(form: NgForm){
   this._carersService.Save(this.model).subscribe(resp =>{
     if(resp){
       form.resetForm()
       this.type  = "success"
       this.message = 'La carrera se ha guardado correctamente.'
     }else{
       this.type  = "error"
       this.message = 'Ocurrio un error al gurdar.'
     }
     this.alertVisible = true
     setTimeout(() => {
     this.alertVisible = false
   }, 2000)
   })

  }
  addCharacter(code){
    if(code.length == 4 || code.length == 9 )
      this.model['code'] = code + '-'
  }
  validateCode(code){

    if(code.valid){
      this._helpersService.validateCodeCarer(code.value).subscribe(resp=>{
        if(resp)
          this.codeValid = true
        else
          this.codeValid = false
      })
    }
  }
}

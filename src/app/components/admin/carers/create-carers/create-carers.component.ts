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
  styleUrls: ['../../../../../assets/css/panelStyles.css',
  '../../../../../assets/css/containerStyles.css']

})
export class CreateCarersComponent implements OnInit {
  model = {"code": '','name':'','alias':'','extension':''}
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
    this._extensionsService.getExtension().subscribe(data=>{this.extensions = data}) //get extensions list
    this.model['extension'] = localStorage.getItem('extension') //set user extension
  }

  Save(form: NgForm){
    /* Call function Save from service */
    this._carersService.Save(this.model).subscribe(resp =>{
      /* Validate response */
      if(resp){
        form.resetForm() //rest form
        this.type  = "success" //alert type
        this.message = 'La carrera se ha guardado correctamente.' //alert message
      }else{
        this.type  = "error" //alert type
        this.message = 'Ocurrio un error al gurdar.' //alert message
      }
      this.alertVisible = true //show alert
      /*Hide alert in 2 secunds*/
      setTimeout(() => {
        this.alertVisible = false //hide alert
      }, 2000)
    })
  }
  addCharacter(code){
    if(code.length == 4 || code.length == 9 )
      this.model['code'] = code + '-'
  }
  validateCode(code){
    /*validate code */
    if(code.valid){
      /*Call validateCodeCarer from service*/
      this._helpersService.validateCodeCarer(code.value).subscribe(resp=>{
        /*validate response*/
        if(resp)
          this.codeValid = true
        else
          this.codeValid = false
      })
    }
  }
}

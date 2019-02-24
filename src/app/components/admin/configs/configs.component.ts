import { Component, OnInit } from '@angular/core';
import { ConfigService, Config } from '../../../services/config.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-configs',
  templateUrl: './configs.component.html',
  styleUrls:['../../../../assets/css/panelStyles.css',
              '../../../../assets/css/porfileStyles.css',
              '../../../../assets/css/containerStyles.css'
]
})
export class ConfigsComponent implements OnInit {
  configData:any = []
  model = {}
  data = {}
  changePass: boolean = false
  isEditable: boolean = false
  isNewconfig: boolean = false
  emailValid: boolean = true
  alertPass: boolean = false
  alertisVisible: boolean = false
  type: string
  message: string
  constructor(private _configService: ConfigService,
              private _titleService: Title) {
                this._titleService.setTitle('Configuracion')
   }

  ngOnInit() {
    this.getData()
  }

  getData(){
    /*Call function getConfig from service*/
    this._configService.getConfig().subscribe(data=>{
      this.configData = data //get getData
      /*set data in form*/
      this.data['startTime'] = data['startTime']
      this.data['endTime'] = data['endTime']
      this.data['sbreakTime'] = data['sbreakTime']
      this.data['ebreakTime'] = data['ebreakTime']
      this.data['durationModule'] = data['durationModule']
      this.data['durationBreak'] = data['durationBreak']
    })
  }

  Edit(){
    /*Validate editable status*/
    if(this.isEditable)
      this.isEditable = false //hide form
    else{
      this.isEditable = true//show form
      /*sjpw data in form*/
      this.data['startTime'] = this.configData.startTime
      this.data['endTime'] = this.configData.endTime
      this.data['durationModule'] = this.configData.durationModule
      this.data['sbreakTime'] = this.configData.sbreakTime
      this.data['ebreakTime'] = this.configData.ebreakTime
      this.data['durationBreak'] = this.configData.durationBreak
    }
  }

  Save(){
    this._configService.Save(this.data).subscribe(resp=>{
      if(resp){
        this.isEditable = false;
        this.isNewconfig = false;
        this.getData()
        this.type  = "success"
        this.message = 'La cofiguracion se ha guardado correctamente.'
      }
      else{
        this.type  = "error"
        this.message = 'No se ha poodido guardar.'
      }
      this.alertisVisible = true
      setTimeout(() => {
        this.alertisVisible = false
      }, 2000)
    })
  }

  Update(){
    this.data['id'] = this.configData.idConfig
    this._configService.Update(this.data).subscribe(resp=>{
      if(resp){
        this.isEditable = false;
        this.isNewconfig = false;
        this.getData()
        this.type  = "success"
        this.message = 'La configuracion ha sido actualizada!.'
      }
      else{
        this.type  = "error"
        this.message = 'No se ha poodido actualizar.'
      }
      this.alertisVisible = true
      setTimeout(() => {
        this.alertisVisible = false
      }, 2000)
    })
  }

  newConfig(){
    this.data = {}//clea form
    /* validate isNewconfig status*/
    if(this.isNewconfig){
        this.isNewconfig = false //hide form
        this.isEditable = false //hide form
    }
    else{
        this.isNewconfig = true //hide form
        this.isEditable = true //hide form
    }
  }

}

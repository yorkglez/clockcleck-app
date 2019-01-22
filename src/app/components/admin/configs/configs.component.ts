import { Component, OnInit } from '@angular/core';
import { ConfigService, Config } from '../../../services/config.service';

@Component({
  selector: 'app-configs',
  templateUrl: './configs.component.html',
  styleUrls:['../../../../assets/css/panelStyles.css']
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
  constructor(private _configService: ConfigService) { }

  ngOnInit() {
    this.getData()
  }
  getData(){
    this._configService.getConfig().subscribe(data=>{
      this.configData = data
      console.log(this.configData)
      this.data['startTime'] = data['startTime']
      this.data['endTime'] = data['endTime']
      this.data['sbreakTime'] = data['sbreakTime']
      this.data['ebreakTime'] = data['ebreakTime']
      this.data['durationModule'] = data['durationModule']
      this.data['durationBreak'] = data['durationBreak']
    })
  }
  Edit(){
    if(this.isEditable)
      this.isEditable = false
    else{
      this.isEditable = true
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
    this.data = {}
    if(this.isNewconfig){
        this.isNewconfig = false
        this.isEditable = false
    }

    else{
        this.isNewconfig = true
        this.isEditable = true
    }

  }

}

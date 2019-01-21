import { Component, OnInit } from '@angular/core';
import { ConfigService } from '../../../services/config.service';

@Component({
  selector: 'app-configs',
  templateUrl: './configs.component.html',
  styleUrls:['../../../../assets/css/panelStyles.css']
})
export class ConfigsComponent implements OnInit {
  configData = []
  model = {}
  data = {}
  changePass: boolean = false
  editable: boolean = false
  emailValid: boolean = true
  alertPass: boolean = false
  date = new Date().toLocaleTimeString()
//  public timeFrom: string =  "07:00";
  time = new Date (new Date().toDateString() + ' ' + '10:45')
  constructor(private _configService: ConfigService) { }

  ngOnInit() {
    console.log(this.date)
    this._configService.getConfig().subscribe(data=>{
      this.configData = data
    })
  }
  validateHour(value){

    value.value = "hola"
    console.log(value.value)
    // if(value.length == 2)
    //   console.log()
  }

  Edit(){
    console.log(this.configData)
    this.editable = true
    let st = new Date()
    //this.data['startTime'] = new Date(1970, 0, 1, 14, 57, 0)
    // this.data['endTime'] = this.configData.endTime
    // this.data['durationModule'] = this.configData.durationModule
    // this.data['sbreakTime'] = this.configData.sbreakTime
    // this.data['ebreakTime'] = this.configData.ebreakTime
    // this.data['durationBreak'] = this.configData.durationBreak
    // if(this.editable)
    //   this.editable = false
    // else
    //   this.editable = true
  }
  saveChanges(){
    console.log(this.data)
  }
  newConfig(){
    this.data = {}
    this.editable = true;
  }

}

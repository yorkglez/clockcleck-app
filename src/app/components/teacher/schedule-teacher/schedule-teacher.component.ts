import { Component, OnInit } from '@angular/core';
import { ScheduleService,Hour,Schedule, Sc } from '../../../services/schedule.service';
import { Title } from '@angular/platform-browser';


@Component({
  selector: 'app-schedule-teacher',
  templateUrl: './schedule-teacher.component.html',
  styleUrls: ['../../../../assets/css/panelStyles.css',
              '../../../../assets/css/tableStyles.css',
              '../../../../assets/css/scheduleStyles.css'
            ]
})
export class ScheduleTeacherComponent implements OnInit {
  hours:any = []
  schedule: boolean = true
  lunes = []
  martes = []
  miercoles = []
  jueves  = []
  viernes  = []
  bTime: number
  constructor(private _scheduleService: ScheduleService,
              private _titleService: Title) {
                this._titleService.setTitle('Horario')
  }

  ngOnInit() {
    /*Call function getScheduleConfig from service*/
    this._scheduleService.getScheduleConfig('null').subscribe(data=>{
      this.hours  = data.hours
      this.bTime = data.breakTime
    })
    /*get schedule*/
    this._scheduleService.getSubjectsTeacher().subscribe(data=>{
      /*validate response*/
      if(!data){
        this.schedule = false;
      }
      else{
        this.lunes = data.lunes
        this.martes = data.martes
        this.miercoles= data.miercoles
        this.jueves = data.jueves
        this.viernes = data.viernes
      }
    })
  }

}

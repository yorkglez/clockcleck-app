import { Component, OnInit } from '@angular/core';
import { AcademicloadTeacherService } from '../../../services/academicload-teacher.service';
import { ScheduleService,Hour,Schedule  } from '../../../services/schedule.service';
import { ExtensionsService } from '../../../services/extensions.service';

@Component({
  selector: 'app-academicloadlist',
  templateUrl: './academicloadlist.component.html',
  styleUrls: ['../../../../assets/css/tableStyles.css',
              '../../../../assets/css/panelStyles.css',
              '../../../../assets/css/paginationStyles.css',
              '../../../../assets/css/scheduleStyles.css'
            ]
})
export class AcademicloadlistComponent implements OnInit {
  p: number = 1
  id: string
  ter:string
  teacherName: string
  searchAlert: boolean
  aclist = []
  existsSchedule: boolean = false
  hours: Hour[] = []
  lunes = []
  martes = []
  miercoles = []
  jueves  = []
  viernes  = []
  extensions = []
  model = {}
  bTime: number
  rowCont: number
  itemsPerPage: number = 10
  constructor(private _academicloadteacherService: AcademicloadTeacherService,
              private _scheduleService: ScheduleService,
              private _extensionsService: ExtensionsService) { }

  ngOnInit() {
    this._academicloadteacherService.getAcademicloadList().subscribe(data=>{
      if(!data)
        this.aclist = []
      else
        this.aclist = data
    })
    this._extensionsService.getExtension().subscribe(data=>{this.extensions = data})
    this.model = {"extension": localStorage.getItem('extension')}
  }
  Search(ter,extension){
    this.ter = ter
    this._academicloadteacherService.searchAcademiadloadList(ter,extension).subscribe(data=>{
      if(!data && ter != ''){
        this.aclist = []
        this.searchAlert = true
      }
      else if (!data && ter == '')
        this.aclist = []
      else{
        this.aclist = data
        this.searchAlert = false
      }

    })
  }
  getSchedule(ac){

    this._scheduleService.getScheduleConfig(ac.codeTeacher).subscribe(data=>{
      this.hours  = data.hours
      this.bTime = data.breakTime
    })
    this._scheduleService.getScheduleTeacherbyId(ac.codeTeacher).subscribe(data=>{
      if(!data){
        this.existsSchedule = false
      }
      else{
        this.teacherName = ac.teacherName
        this.lunes = data.lunes
        this.martes = data.martes
        this.miercoles= data.miercoles
        this.jueves = data.jueves
        this.viernes = data.viernes
        this.existsSchedule = true
      }
    })
  }
}

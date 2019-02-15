import { Component, OnInit } from '@angular/core';
import { ReportsService,TeacherSelect, Report } from '../../../../services/reports.service';
import { NgForm } from '@angular/forms';
import { ViewChild } from '@angular/core';
import { ElementRef } from '@angular/core';
import { NgSelectModule } from '@ng-select/ng-select';
import * as jsPDF from 'jspdf';
import 'jspdf-autotable';
import html2canvas from 'html2canvas';
import { ExtensionsService } from '../../../../services/extensions.service';
import { CarersService } from '../../../../services/carers.service';
import {PopoverModule} from "ngx-popover";
import { HttpClient } from '@angular/common/http';
import { SubjectsService } from '../../../../services/subjects.service';
import { Title } from '@angular/platform-browser';
@Component({
  selector: 'app-reports',
  templateUrl: './reports.component.html',
  styleUrls: ['../../../../../assets/css/panelStyles.css',
  '../../../../../assets/css/popoverStyles.css',
  '../../../../../assets/css/alertStyles.css',
  '../../../../../assets/css/paginationStyles.css',
  '../../../../../assets/css/tableStyles.css',
  '../../../../../assets/css/reportStyles.css'
]
})
export class ReportsComponent implements OnInit {

  idx: number
  p: number = 1
  id: number

  ter:string
  type: string
  message: string
  extension: string = localStorage.getItem('extension')

  model = {"week": "day","note": "", "search": "",
  "startDate": "null", "endDate": "null","extension": this.extension,"atType":"","codeTeacher": "","subjectCode": null}

  modelJust = {}
  searchAlert: boolean
  reportOptions: boolean = false
  checksDate: boolean = false
  reportExists: boolean = true
  editable: boolean = false
  notes: boolean = false
  alertVisible: boolean = false
  isAdmin: boolean = false
  isJustification: boolean = true
  date
  dateNow
  teachers: TeacherSelect [] = []
  extensions = []
  carers = []
  subjects = []
  reports = []
  tcSubjects = []
  Schedule = []
  @ViewChild('teachersSelect') public ngSelect: ReportsComponent;

  constructor(private _reportsService: ReportsService,
              private _extensionsService: ExtensionsService,
              private _carersService: CarersService,
              private _subjectsService: SubjectsService,

              private http: HttpClient,
              private _titleService: Title) {
                  this._titleService.setTitle('Reportes')
               }

  ngOnInit() {
    this.date = new Date()
    this.date =  this.date.toLocaleString('en-US', {timeZone: 'America/Mexico_City'})
    this._extensionsService.getExtension().subscribe(data=>{this.extensions = data})
    // this.extension = localStorage.getItem('extension')
    this._reportsService.getselectTeacher(this.extension).subscribe(data=>{
          this.teachers = data
     })
    this._carersService.getSelectCarers(this.extension).subscribe(data=>{
      this.carers = data
    })
    if(localStorage.getItem('type') == 'admin')
      this.isAdmin = true
    else
      this.isAdmin = false
    }
    getSelectSubjects(code){
      this._subjectsService.getSubjectsListTeacher(code).subscribe(data=>{
        this.subjects = data
      })
    }
  downloadReport(ex){
    let extension = this.model.extension
    let week = this.model.week
    let startDate =  this.model.startDate
    let endDate =  this.model.endDate
    var codeTeacher =  this.model.codeTeacher
    var subject =  this.model.subjectCode
    let rType = '';
    if(codeTeacher =='')
      codeTeacher = 'null'
    if(subject == null)
      subject = 'null'
    let params = 'extension='+extension+'&week='+week+'&startDate='+startDate
    +'&endDate='+endDate+'&codeTeacher='+codeTeacher+'&subject='+subject
    window.open('http://localhost/clockcleck-app/test/api/queries/Report/generatePDF.php?'+params)
  }
  Notes(){
    this.notes = true
  }
  saveChanges(){
    if(this.model.note == '')
      this.model.note = this.reports[this.idx].notes
    this.reports[this.idx].type = this.model.atType
    this._reportsService.saveChanges(this.id, this.model.note,this.model.atType).subscribe(resp=>{
      if(resp){
        this.type  = "success"
        this.message = 'La asistencia se ha cambiado correctamente.'
      }else{
        this.type  = "error"
        this.message = 'Ocurrio un error al gurdar.'
      }
      this.alertVisible = true
      setTimeout(() => {
        this.alertVisible = false
      }, 1300)
    })
    this.idx = 0
    this.id = 0
    this.model.note = ""

  }

  getSubjectbyDate(date){
    this._reportsService.getSubjectbyDate(date,this.model['teachersSelect']).subscribe(data=>{
      this.tcSubjects = data
    })
  }
  getSchedulelist(id,date){
    this._reportsService.getSchedulelist(id,this.model['teachersSelect'],date).subscribe(data=>{
      this.Schedule = data
    })
  }

  createAttendance(){
      console.table(this.modelJust)
      this._reportsService.createAttendance(this.modelJust).subscribe(resp=>{
        if(resp){
          this.type  = "success"
          this.message = 'La justificacion ha sido creada correctamente.'
          this.modelJust = {}
          // this.Schedule = []
        }else{
          this.type  = "error"
          this.message = 'Ocurrio un error al intentar gurdar.'
        }
        this.alertVisible = true
        setTimeout(() => {
          this.alertVisible = false
        }, 1300)
      })
  }
  showJusti(){
    if(this.isJustification)
      this.isJustification = false
    else
      this.isJustification = true
    this.modelJust = {}
  }

  getReport(){
    console.log(this.model.subjectCode)
    if((this.model.startDate != 'null' && this.model.endDate != 'null') || this.model.week != 'null'){
      this._reportsService.getReports(this.model).subscribe(data=>{
        if(!data){
          this.reports = []
          this.reportExists = false
        }
        else{
          this.reports = data
          this.reportExists = true
        }
      })
    }
  }
  getTeachers(ex){
    this.extension = ex
    this._reportsService.getselectTeacher(ex).subscribe(data=>{
      if(!data)
        this.teachers = []
      else
          this.teachers = data
     })
  }
  getCarers(ex){
    this._carersService.getSelectCarers(ex).subscribe(data=>{
      this.carers = data
    })
  }

  getCarersTeacher(code){
    if(code == null){
      this.getCarers(this.model.extension)
    }else{
      this._carersService.getSelectCarersTeacher(this.extension,code).subscribe(data=>{
        if(!data)
          this.carers = []
        else
          this.carers = data
       })
    }
  }
  showDate(value){
    if(value == 'bydate'){
      this.checksDate = true
      this.model.week = 'null'
    }
    else{
      this.checksDate = false
      this.model.startDate ='null'
      this.model.endDate = 'null'
    }
  }
  Edit(report, i){
    this.editable= true
    this.idx = i
    this.model.atType = report.type
    this.id = report.idAttendance
  }

  downloadFile(data: Response) {
    console.log('pits')
    const blob = new Blob([data], { type: 'application/pdf' });
    console.log(blob)
    const url= window.URL.createObjectURL(blob);
    window.open(url);
  }

}

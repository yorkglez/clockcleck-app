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
               // this.date = new Date()
               // this.date =  this.date.toLocaleString('en-US', {timeZone: 'America/Mexico_City'})
               /*Get carers*/
              // this._carersService.getSelectCarers(this.extension).subscribe(data=>{
              //   this.carers = data
              // })
  ngOnInit() {
    this._extensionsService.getExtension().subscribe(data=>{this.extensions = data})//get extension
    /*get teachers*/
    this._reportsService.getselectTeacher(this.extension).subscribe(data=>{
          this.teachers = data
     })
    /*Validate user type*/
    if(localStorage.getItem('type') == 'admin')
      this.isAdmin = true
    else
      this.isAdmin = false
    }

    getSelectSubjects(code){
      /*get subjects*/
      this._subjectsService.getSubjectsListTeacher(code).subscribe(data=>{
        this.subjects = data
      })
    }
  downloadReport(type){
    /*get report params*/
    let extension = this.model.extension
    let week = this.model.week
    let startDate =  this.model.startDate
    let endDate =  this.model.endDate
    var codeTeacher =  this.model.codeTeacher
    var subject =  this.model.subjectCode
    /*Validate if teachers is selected */
    if(codeTeacher =='')
      codeTeacher = 'null'
    if(subject == null)
      subject = 'null'
    let params = 'extension='+extension+'&week='+week+'&startDate='+startDate
    +'&endDate='+endDate+'&codeTeacher='+codeTeacher+'&subject='+subject
    let route = ''
    /*validate report type*/
    if(type == 'pdf')
      route = 'generatePDF.php?'
    else
      route = 'generateExcel.php?'
    //download report
    window.open('http://localhost/clockcleck-app/test/api/queries/Report/'+route+params)
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
    /*get subjects*/
    this._reportsService.getSubjectbyDate(date,this.model['teachersSelect']).subscribe(data=>{
      this.tcSubjects = data
    })
  }

  getSchedulelist(id,date){
    /*get Schedule*/
    this._reportsService.getSchedulelist(id,this.model['teachersSelect'],date).subscribe(data=>{
      this.Schedule = data
    })
  }

  createAttendance(){
    /*Call service*/
    this._reportsService.createAttendance(this.modelJust).subscribe(resp=>{
      /*Validate response*/
      if(resp){
        this.type  = "success" //type alert
        this.message = 'La justificacion ha sido creada correctamente.' //alert message
        this.modelJust = {}
      }
      else{
        this.type  = "error" //type alert
        this.message = 'Ocurrio un error al intentar gurdar.' //alert message
      }
      this.alertVisible = true //show alert
      setTimeout(() => {
        this.alertVisible = false //hide alert
      }, 1300)
    })
  }

  showJusti(){
    /*validate isJustification status*/
    if(this.isJustification)
      this.isJustification = false // hide form
    else
      this.isJustification = true //show form
    this.modelJust = {} //clear model
  }

  getReport(){
    /* Validate inputs date*/
    if((this.model.startDate != 'null' && this.model.endDate != 'null') || this.model.week != 'null'){
      /*get Report*/
      this._reportsService.getReports(this.model).subscribe(data=>{
        /* Validate response */
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
    this.extension = ex //get extexion
    /*get teachers*/
    this._reportsService.getselectTeacher(ex).subscribe(data=>{
      /*validate response*/
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
    /* Validate option bydate*/
    if(value == 'bydate'){
      this.checksDate = true //enable inputs dates
      this.model.week = 'null'
    }
    else{
      this.checksDate = false //disabled inputs dates
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

  // downloadFile(data: Response) {
  //   console.log('pits')
  //   const blob = new Blob([data], { type: 'application/pdf' });
  //   console.log(blob)
  //   const url= window.URL.createObjectURL(blob);
  //   window.open(url);
  // }

}

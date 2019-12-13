import { Component, OnInit } from '@angular/core';
import { ScheduleService, Hour } from '../../../services/schedule.service';
import { AcademicloadTeacherService, Schedule } from '../../../services/academicload-teacher.service';
import { NgForm,FormControl} from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { NgSelectConfig } from '@ng-select/ng-select';
import { SubjectsService, SubjectList } from '../../../services/subjects.service';
import { CarersService } from '../../../services/carers.service';
import { Title } from '@angular/platform-browser';
@Component({
  selector: 'app-academicload-teacher',
  templateUrl: './academicload-teacher.component.html',
  styleUrls: ['../../../../assets/css/panelStyles.css',
              '../../../../assets/css/tableStyles.css',
                '../../../../assets/css/academicloadStyles.css'
             ]
})
export class AcademicloadTeacherComponent implements OnInit {
    type: string
    message: string
    hours = []
    hoursSelect:any = []
    days = []
    model = {'day':'','nameSubject':'','alias':'','startTime':'','endTime':'','semester':'','objetive':''}
    semesters = [];
    subjects: SubjectList[] = []
  //  subjectsName = []
    academicload = []
    carers = []
    etSlice: number = 1
  //  newAc = []
    oldAc = []
    idx: number
    i: number
    isEditable: boolean = false
    alertisVisible: boolean = false
    subject
    constructor(private config: NgSelectConfig,
      private _scheduleService: ScheduleService,
      private _academicloadService: AcademicloadTeacherService,
      private _subjectsService: SubjectsService,
      private _carersService: CarersService,
      private _titleService: Title)
    {
      this._titleService.setTitle('Carga horaria')
      this.config.notFoundText = 'No se encontraron resultados';
     }

  /*  ngOnInit() {
      this._subjectsService.getSubjectList().subscribe(data=>{this.subjects  = data})
      this._scheduleService.getHours().subscribe(data=>{
        this.hoursSelect = data
        for (let i = 0; i < Object.keys(data).length; i++) {
            this.hours.push(this.hoursSelect[i])
        }
      })
      this.days = this._academicloadService.getDays()
      this.semesters = this._scheduleService.getSemesters()
      this._carersService.getSelectCarers().subscribe(data=>{this.carers = data})
    }

    saveSchedule(event){
      event.preventDefault();
      console.log(this.schedule)
      this._academicloadService.AssingSubject(this.schedule).subscribe(resp=>{
        console.log(resp)
      })
    }
    getSelectedSubject(idx) {
     this.model['codeSubject'] = this.subjects[idx].codeSubject
     this.model['subjectSelect'] = this.subjects[idx].name
    //  console.log(idx)
    }

    getSelectedCarer(idx) {
      this.model['codeCarer'] = this.carers[idx].codeCarer
      this.model['carerSelect'] = this.carers[idx].name
    }
    addSubject(form: NgForm){
      this.schedule.push(this.model)
      this.model = {}
      //form.resetForm()
      // console.log(this.schedule)
    }


    sliceHours(idx){
      // this.model['startTime'] = this.hoursSelect[idx]
      // console.log(this.model)
      // this.etSlice  = parseInt(idx) + 1
    }*/
    ngOnInit() {
      this._subjectsService.getSubjectList().subscribe(data=>{this.subjects  = data}) //get subjects lisat
      /**/
      this._scheduleService.getHours().subscribe(data=>{
        this.hoursSelect = data
        for (let i = 0; i < Object.keys(data).length; i++)
            this.hours.push(this.hoursSelect[i])
      })

      this.days = this._academicloadService.getDays() //get days
      this.semesters = this._scheduleService.getSemesters() //get hours
      this._carersService.getSelectCarers(localStorage.getItem('extension')).subscribe(data=>{this.carers = data}) //get extensions
      /*get academicload*/
      this._academicloadService.getAcademicload().subscribe(data=>{
        this.academicload = data //get data
        this.oldAc.push(this.academicload) //add data to list
      })
    }

    Edit(idx){
      this.idx = idx //get id
      this.isEditable = true //shpw form
      /*show data in form*/
      this.model['objetive'] = this.academicload[idx].objetive
      this.model['day'] = this.academicload[idx].day
      this.model['startTime'] = this.academicload[idx].startTime
      this.model['endTime'] = this.academicload[idx].endTime
      this.model['semester'] = this.academicload[idx].semester
      this.model['nameSubject'] = this.academicload[idx].nameSubject
      this.model['alias'] = this.academicload[idx].alias
    }

    getSelectedSubject(idx) {
      this.model['codeSubject'] = this.subjects[idx].codeSubject
      this.model['nameSubject'] = this.subjects[idx].name
    }

    getSelectedCarer(idx) {
      this.model['codeCarer'] = this.carers[idx].codeCarer
      this.model['alias'] = this.carers[idx].alias
    }

    addSubject(form: NgForm){

      /*validate isEditable status*/
      if(this.isEditable){
        let objective = this.model['objetive'] //get objetive
        let id = this.academicload[this.idx].idSubjectlist //get
        /*Search subejcts with similar id*/
        for (let i = 0; i < this.academicload.length; i++) {
            /*compare id*/
            if (id == this.academicload[i].idSubjectlist)
              this.academicload[i].objetive = objective
        }
        /*add subject data to array position*/
        this.academicload[this.idx].objetive = this.model['objetive']
        this.academicload[this.idx].day =  this.model['day']
        this.academicload[this.idx].startTime = this.model['startTime']
        this.academicload[this.idx].endTime =   this.model['endTime']
        this.academicload[this.idx].semester = this.model['semester']
        this.academicload[this.idx].nameSubject = this.model['nameSubject']
        this.academicload[this.idx].alias = this.model['alias']
        this.isEditable = false
      }
      else
        this.academicload.push(this.model) //add new subject
      // this.model = {} //clear model
      this.model = {'day':'','nameSubject':'','alias':'','startTime':'','endTime':'','semester':'','objetive':''}
      form.resetForm() //clear form
    }

    updateSubject(form: NgForm){
      let objective = this.model['objetive'] //get objetive
      let id = this.academicload[this.idx].idSubjectlist //get
      /*Search subejcts with similar id*/
      for (let i = 0; i < this.academicload.length; i++) {
          /*compare id*/
          if (id == this.academicload[i].idSubjectlist)
            this.academicload[i].objetive = objective
      }
      /*validate isEditable status*/
      if(this.isEditable){
        /*add subject data to array position*/
        this.academicload[this.idx].objetive = this.model['objetive']
        this.academicload[this.idx].day =  this.model['day']
        this.academicload[this.idx].startTime = this.model['startTime']
        this.academicload[this.idx].endTime =   this.model['endTime']
        this.academicload[this.idx].semester = this.model['semester']
        this.academicload[this.idx].nameSubject = this.model['nameSubject']
        this.academicload[this.idx].alias = this.model['alias']
        this.isEditable = false
      }
      else
        this.academicload.push(this.model) //add new subject
      // this.model = {} //clear model
      this.model = {'day':'','nameSubject':'','alias':'','startTime':'','endTime':'','semester':'','objetive':''}
      form.resetForm() //clear form
    }

    sliceHours(idx){
      this.etSlice  = parseInt(idx) + 1
    }

    saveSchedule(event){
      event.preventDefault();
      this._academicloadService.Update(this.academicload).subscribe(resp=>{
        if(resp){
            this.type = 'success'
            this.message = 'La carga academica se ha guardado correctamente.'
        }
        else{
          this.type = 'error'
          this.message = 'Ocurrio un error al intentar guardar.'
        }
        this.alertisVisible = true
        setTimeout(() => {
          this.alertisVisible = false
        }, 1300)
      })
    }

      getId(subject){
        this.subject = subject
      }

      Delete(){
        // console.log(this.subject.idSchedule)
        this._academicloadService.Delete(this.subject.idSchedule).subscribe(resp=>{
          if(resp)
            this.academicload.splice(this.academicload.indexOf(this.subject),1)
        })
      }
}

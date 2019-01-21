import { Component, OnInit } from '@angular/core';
import { NgSelectConfig } from '@ng-select/ng-select';
import { ScheduleService, Hour } from '../../../services/schedule.service';
import { AcademicloadTeacherService, Schedule } from '../../../services/academicload-teacher.service';
import { SubjectsService, SubjectList } from '../../../services/subjects.service';
import { CarersService } from '../../../services/carers.service';
import { FormBuilder } from '@angular/forms';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-editacademicload',
  templateUrl: './editacademicload.component.html',
  styleUrls: [
              '../../../../assets/css/tableStyles.css']
})
export class EditacademicloadComponent implements OnInit {
  hours = []
  hoursSelect:any = []
  days = []
  model ={}
  schedule = []
  codeTeacher:string = '1414'
  semesters = [];
  subjects: SubjectList[] = []
  subjectsName = []
  academicload = []
  carers = []
  etSlice: number = 1
  newAc = []
  oldAc = []
  idx: number
  i: number
  editable: boolean = false
  constructor(private config: NgSelectConfig,
    private _scheduleService: ScheduleService,
    private _academicloadService: AcademicloadTeacherService,
    private _subjectsService: SubjectsService,
    private _carersService: CarersService,
    private formBuilder: FormBuilder) { }

  ngOnInit() {
    this._subjectsService.getSubjectList().subscribe(data=>{this.subjects  = data})
    this._scheduleService.getHours().subscribe(data=>{
      this.hoursSelect = data
      for (let i = 0; i < Object.keys(data).length; i++) {
          this.hours.push(this.hoursSelect[i])
      }
    })
    this.days = this._academicloadService.getDays()
    this.semesters = this._scheduleService.getSemesters()
    this._carersService.getSelectCarers(localStorage.getItem('extension')).subscribe(data=>{this.carers = data})
    this._academicloadService.getAcademicload().subscribe(data=>{
      this.academicload = data
      this.oldAc.push(this.academicload)
    //  console.log(this.oldAc)
    })
  }
  Edit(idx){
    this.idx = idx
    this.editable = true
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
    if(this.editable){
      this.academicload[this.idx].objetive = this.model['objetive']
      this.academicload[this.idx].day =  this.model['day']
      this.academicload[this.idx].startTime = this.model['startTime']
      this.academicload[this.idx].endTime =   this.model['endTime']
      this.academicload[this.idx].semester = this.model['semester']
      this.academicload[this.idx].nameSubject = this.model['nameSubject']
      this.academicload[this.idx].alias = this.model['alias']
      this.editable = false
    }else{
      this.academicload.push(this.model)
    }
    this.model = {}
    form.resetForm()
  }
  sliceHours(idx){
    this.etSlice  = parseInt(idx) + 1
  }
  saveSchedule(event){
    event.preventDefault();
    console.log(this.academicload)
    this._academicloadService.Update(this.academicload).subscribe(resp=>{
      console.log(resp)
    })
  }

}

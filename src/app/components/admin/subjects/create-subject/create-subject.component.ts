import { Component, OnInit } from '@angular/core';
import { SubjectsService } from '../../../../services/subjects.service';
import { NgForm } from '@angular/forms';
import { HelpersService } from '../../../../services/helpers.service';

@Component({
  selector: 'app-create-subject',
  templateUrl: './create-subject.component.html',
  styleUrls: ['../../../../../assets/css/panelStyles.css',
  '../../../../../assets/css/tableStyles.css'
        ]
})
export class CreateSubjectComponent implements OnInit {
  model = {}
  subjects = {}
  subjectsList = []
  idx: number
  isSequence: boolean = true
  codeValid: boolean = false
  secodeValid: boolean = true
  alertVisible: boolean = false
  updateItems: boolean = false
  code: string = '';
  secCode: string = '';
  type: string
  message: string
  constructor(private _subjectsService: SubjectsService,
              private _helpersService: HelpersService,) { }

  ngOnInit() {
  }

  Save(form: NgForm){
    if(this.codeValid && this.secodeValid){
      if (!this.isSequence)
        this.subjectsList.push(this.model)

      this._subjectsService.saveSubject(this.subjectsList,this.isSequence).subscribe(resp=>{
        if(resp){
          this.type  = "success"
          this.message = 'La materia se ha guardado correctamente.'
          form.resetForm()
          this.subjectsList = []
          this.model = {}
          this.isSequence = false
        }else{
          this.type  = "error"
          this.message = 'Ocurrio un error al gurdar.'
        }
        this.alertVisible = true
        setTimeout(() => {
        this.alertVisible = false
        }, 2500)
      })
    }
  }
  checkSequence(sequence){

    if (sequence == 'true' && (this.model['code'] != undefined  && this.model['name'] != undefined && this.model['credits'] != undefined)) {
      this.subjectsList.push(this.model)
      this.isSequence = true
    }
    else
      this.isSequence = false
  }
  addSubject(){
    this.subjectsList.push(this.subjects)
    this.subjects = {}
  }
  deleteItem(idx){
    this.subjectsList.splice(this.subjectsList.indexOf(idx),1)
  }

  Edit(idx){
      this.idx = idx
      this.updateItems = true
      this.subjects['code'] = this.subjectsList[idx].code
      this.subjects['name'] = this.subjectsList[idx].name
      this.subjects['credits'] = this.subjectsList[idx].credits
  }
  updateItem(idx){
    this.subjectsList[idx].code = this.subjects['code']
    this.subjectsList[idx].name = this.subjects['name']
    this.subjectsList[idx].credits = this.subjects['credits']
    this.subjects = {}
    this.updateItems = false
  }
  addCharater(code){
    console.log(code.name)
    // code.value = 'hola'
    // if(code.length == 3)
    //   this.model['code'] = code + '-'
  }
  validateCode(code){
      this.code = code
      if(code.length == 8){
        this.codeValid = true
        if(this.subjectsList.length > 1){

          for (let i = 1; i < this.subjectsList.length; i++) {
            if(this.subjectsList[i].code == code){
              this.codeValid = false
              break;
            }
            else
              this.codeValid = true
          }
        }

        if (this.codeValid) {
          this._helpersService.validateCodeSubject(code).subscribe(resp=>{
            if(resp)
              this.codeValid = true
            else
              this.codeValid = false
          })
        }
      }
      else
        this.codeValid = false
  }

  validateCodeSc(code){
    if(code != this.code && code.length == 8){

        for (let i = 0; i < this.subjectsList.length; i++) {
            if(this.subjectsList[i].code == code){
              this.secodeValid = false
              break;
            }
            else
              this.secodeValid = true
        }

        if (this.secodeValid) {
          this._helpersService.validateCodeSubject(code).subscribe(resp=>{
            if(resp)
              this.secodeValid = true
            else
              this.secodeValid = false
          })
        }
    }
    else
      this.secodeValid = false
  }


}

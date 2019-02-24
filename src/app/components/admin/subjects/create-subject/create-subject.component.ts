import { Component, OnInit } from '@angular/core';
import { SubjectsService } from '../../../../services/subjects.service';
import { NgForm } from '@angular/forms';
import { HelpersService } from '../../../../services/helpers.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-create-subject',
  templateUrl: './create-subject.component.html',
  styleUrls: ['../../../../../assets/css/panelStyles.css',
  '../../../../../assets/css/tableStyles.css',
  '../../../../../assets/css/containerStyles.css'
        ]
})
export class CreateSubjectComponent implements OnInit {
  model = {"code":'','name':'','credits':''}
  subjects = {"code":''}
  subjectsList = []
  idx: number
  isSequence: boolean = false
  codeValid: boolean = false
  secodeValid: boolean = true
  alertVisible: boolean = false
  updateItems: boolean = false
  code: string = '';
  secCode: string = '';
  type: string
  message: string
  radio:boolean = false
  constructor(private _subjectsService: SubjectsService,
              private _helpersService: HelpersService,
              private _titleService: Title) {
                this._titleService.setTitle('Nueva materia')
              }

  ngOnInit() {
  }

  Save(form: NgForm){
    /*validate codes*/
    if(this.codeValid && this.secodeValid){
      if (!this.isSequence)
      this.subjectsList.push(this.model)
      /*call function saveSubject from Service*/
      this._subjectsService.saveSubject(this.subjectsList,this.isSequence).subscribe(resp=>{
        if(resp){
          this.type  = "success" //alert type
          this.message = 'La materia se ha guardado correctamente.'//alert message
          form.resetForm()//reset form
          this.subjectsList = []
          this.model.code = ''
          this.isSequence = false
        }else{
          this.type  = "error"//alert type
          this.message = 'Ocurrio un error al gurdar.'//alert message
        }
        this.alertVisible = true //show alert
        /*hide alert in 2 secunds*/
        setTimeout(() => {
          this.alertVisible = false//hide alert
        }, 2500)
      })
    }
  }

  checkSequence(sequence){
    /*Validate squence */
    if (sequence && (this.model['code'] != undefined
      && this.model['name'] != undefined
      && this.model['credits'] != undefined)) {
        this.subjectsList.push(this.model) //add model to list
        this.isSequence = true //show sequence from
    }
    else
      this.isSequence = false
  }

  addSubject(){
    this.subjectsList.push(this.subjects) //add subjects to list
    this.subjects = {"code":''} //clear code
  }


  deleteItem(idx){
    this.subjectsList.splice(this.subjectsList.indexOf(idx),1) //remove item from list
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
    this.subjects = {"code":''}
    this.updateItems = false
  }

  addCharater(code){
    if(code.length == 3)
      this.model['code'] = code + '-'
  }

  addCharaterSq(code){
    if(code.length == 3)
      this.subjects['code'] = code + '-'
  }

  validateCode(code){
      this.code = code //get subject code
      /* validate code length*/
      if(code.length == 8){
        this.codeValid = true // show code valid
        /* validate list length*/
        if(this.subjectsList.length > 1){
          /*search actual code in list*/
          for (let i = 1; i < this.subjectsList.length; i++) {
            /* compare actual code with code from list*/
            if(this.subjectsList[i].code == code){
              this.codeValid = false
              break;
            }
            else
              this.codeValid = true
          }
        }
        /* validate if code is valid*/
        if (this.codeValid) {
          /*call function validateCodeSubject from service*/
          this._helpersService.validateCodeSubject(code).subscribe(resp=>{
            /*validate response*/
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
    /* validate if squence code exist*/
    if(code != this.code && code.length == 8){
      /*search actual code in list */
      for (let i = 0; i < this.subjectsList.length; i++) {
        /* compare actual code with code from list*/
        if(this.subjectsList[i].code == code){
          this.secodeValid = false
          break;
        }
        else
        this.secodeValid = true
      }
      /* validate if code is valid*/
      if (this.secodeValid) {
        this._helpersService.validateCodeSubject(code).subscribe(resp=>{
          /*validate response*/
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

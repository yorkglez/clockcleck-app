import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { SubjectsService } from '../../../../services/subjects.service';
import { Router } from '@angular/router';
import { HelpersService } from '../../../../services/helpers.service';
import { NgForm } from '@angular/forms';

@Component({
  selector: 'app-edit-subject',
  templateUrl: './edit-subject.component.html',
  styleUrls: ['../../../../../assets/css/panelStyles.css',
              '../../../../../assets/css/tableStyles.css'
]
})
export class EditSubjectComponent implements OnInit {
  model = {}
  subjects = {}
  id:string;
  subjectsList = []
//  removes = []
  idx: number
  updateItems: boolean = false
  codeValid: boolean = true
  secodeValid: boolean = true
  isSequence: boolean = true
  alertVisible: boolean = false
  code: string = ''
  secCode: string = ''
  type: string
  message: string
  constructor(private _subjectsService: SubjectsService,
              private activatedRoute:ActivatedRoute,
              private _helpersService: HelpersService,
              private router: Router) { }

  ngOnInit() {
    this.activatedRoute.params.subscribe( params => {
      this.id = params['id']
      this._subjectsService.getSubjectbyId(this.id).subscribe(data=>{
        this.model['code'] = data[0].codeSubject
        this.model['name'] = data[0].name
        this.model['credits'] = data[0].credits
        // if(data[0].sequence == '0')
        //   this.isSequence = false
        // else
        //   this.isSequence = true
        for (let i = 1; i < data.length; i++)
          this.subjectsList.push(data[i])
      })
    })
  }
  showSequence(value){
    if(value == 'true')
      this.isSequence = true
    else
      this.isSequence = false
  }

  validateCode(code){
      this.code = code
      if(code != this.secCode && code.length == 8 && code != this.id){
          this._helpersService.validateCodeSubject(code).subscribe(resp=>{
            if(resp)
              this.codeValid = true
            else
              this.codeValid = false
          })
      }
      else if(code == this.id)
        this.codeValid = true
      else
        this.codeValid = false
  }

  validateCodeSc(code){
    //Validate if code size is valid
    if(code != this.code && code.length == 8){
      console.log(code)
      if(this.subjectsList[this.idx].codeSubject != code){
        //Validate code in list
        for (let i = 0; i < this.subjectsList.length; i++) {
            if(this.subjectsList[i].code == code){
              this.secodeValid = false
              break;
            }
            else
              this.secodeValid = true
        }
        //Validate code in api
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
        this.secodeValid = true

    }
    else
      this.secodeValid = false
  }

  Edit(idx){
      this.idx = idx
      this.updateItems = true
      this.subjects['code'] = this.subjectsList[idx].codeSubject
      this.subjects['name'] = this.subjectsList[idx].name
      this.subjects['credits'] = this.subjectsList[idx].credits
  }
  updateItem(idx){
    this.subjectsList[idx].codeSubject = this.subjects['code']
    this.subjectsList[idx].name = this.subjects['name']
    this.subjectsList[idx].credits = this.subjects['credits']
    this.updateItems = false
  }
  deleteItem(){
    let code = this.subjectsList[this.idx].codeSubject
    this._subjectsService.removeSquence(code).subscribe(resp=>{
      if(resp){
        this.subjectsList.splice(this.idx,1)
      }
    })
  }
  getId(idx){
    this.idx = idx
  }
  Save(form: NgForm,sequence){
    if(this.codeValid && this.secodeValid){
      this._subjectsService.updateSubject(this.model,this.id).subscribe(resp=>{
        if(resp){
          this.type  = "success"
          this.message = 'La materia ha sido actualizada, volver a '
        }else{
          this.type  = "error"
          this.message = 'Ocurrio un error al gurdar.'
        }
        this.alertVisible = true
        setTimeout(() => {
        this.alertVisible = false
        this.router.navigate(['/subjects'])
      }, 1000)
      })
    }
  }

}

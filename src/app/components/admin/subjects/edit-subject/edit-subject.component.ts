import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { SubjectsService } from '../../../../services/subjects.service';
import { Router } from '@angular/router';
import { HelpersService } from '../../../../services/helpers.service';
import { NgForm } from '@angular/forms';
import { Title } from '@angular/platform-browser';

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
              private router: Router,
              private _titleService: Title) {
                this._titleService.setTitle('Ediar materia')
              }

  ngOnInit() {
       /* call function params from service */
    this.activatedRoute.params.subscribe( params => {
      this.id = params['id'] //get id from  url param
         /* call getDatabyId function from service */
      this._subjectsService.getDatabyId(this.id).subscribe(data=>{
           /*add subject data to model*/
        this.model['code'] = data[0].codeSubject
        this.model['name'] = data[0].name
        this.model['credits'] = data[0].credits
        /* search subjects in list */
        for (let i = 1; i < data.length; i++)
          this.subjectsList.push(data[i]) //add subject to list
      })
    })
  }

  showSequence(value){
    if(value == 'true')
      this.isSequence = true //show sequences subjects
    else
      this.isSequence = false //hide sequences subjects
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
    /*add subject data to your position*/
    this.subjectsList[idx].codeSubject = this.subjects['code']
    this.subjectsList[idx].name = this.subjects['name']
    this.subjectsList[idx].credits = this.subjects['credits']
    this.updateItems = false //hide update boton
  }

  deleteItem(){
    let code = this.subjectsList[this.idx].codeSubject //get index
    /*Call removeSquence from service*/
    this._subjectsService.removeSquence(code).subscribe(resp=>{
      /*Validate response*/
      if(resp)
        this.subjectsList.splice(this.idx,1) //remove item from array
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

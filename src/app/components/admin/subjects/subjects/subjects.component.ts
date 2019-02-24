import { Component, OnInit } from '@angular/core';
import { SubjectsService } from '../../../../services/subjects.service';
import { Router } from '@angular/router';
import { LoaderService } from '../../../../services/loader.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-subjects',
  templateUrl: './subjects.component.html',
  styleUrls: ['../../../../../assets/css/tableStyles.css',
              '../../../../../assets/css/paginationStyles.css',
              '../../../../../assets/css/panelStyles.css',
              '../../../../../assets/css/containerStyles.css'
             ]
})
export class SubjectsComponent implements OnInit {
  p: number = 1
  id: string
  ter:string
  searchAlert: boolean = false
  // inactive: boolean = false
  subjects= []
  subject:any[]
  alertVisible: boolean = false
  type: string
  message: string
  // rowCont: number
  // itemsPerPage: number = 10
  constructor(private _subjectsService: SubjectsService,
    private router: Router,
    private _loaderService: LoaderService,
    private _titleService: Title ) {
      this._titleService.setTitle('Materias')
    }

  ngOnInit() {
    this.getSubjects('1','','all')
  }

  Edit(code){
    this.id = code
    this.router.navigate(['/editsubject',this.id])
  }

  getId(subject){
    this.subject = subject;
  }

  getSubjects(status, ter, sequence){
   this._loaderService.display(true)
    this.searchAlert = false
    this._subjectsService.getSubjects(status,ter, sequence).subscribe(data=>{
      if(!data && ter != ''){
        this.searchAlert = true
        this.ter = ter
        this.subjects = []
      }
      else if(!data && ter =='')
        this.subjects = []
      else
        this.subjects = data
        this._loaderService.display(false)
     })
  }
  showBy(status, ter, type){
    this.getSubjects(status,ter,type)
  }
  deleteSubject(){
    this._subjectsService.changeStatus(this.subject['codeSubject'],'0').subscribe(data=>{
      if(data){
        this.subjects.splice(this.subjects.indexOf(this.subject),1)
        this.type  = "success"
        this.message = 'La carrera se ha guardado correctamente.'
      }else{
        this.type  = "error"
        this.message = 'Ocurrio un error.'
      }
      // this.alertVisible = true
      // setTimeout(() => {
      //   this.alertVisible = false
      // }, 2000)
    })
  }
  Activate(subject){
    this._subjectsService.changeStatus(subject.codeSubject,'1').subscribe(resp=>{
      if(resp){
        this.subjects.splice(this.subjects.indexOf(subject),1)
      }
    })
  }

  Search(ter:string,type:string){
    this.ter = ter
    this._subjectsService.searchSubject(ter,type).subscribe(data=>{
    if(data.length >0){
      this.searchAlert = false
    }else{
      this.searchAlert = true
    }
      this.subjects = data

        }
      )
  }


}

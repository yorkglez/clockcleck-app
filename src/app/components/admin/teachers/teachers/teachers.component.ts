import { Component, OnInit } from '@angular/core';
import { TeachersService } from '../../../../services/teachers.service';
import { NgForm } from '@angular/forms';
import { ExtensionsService } from '../../../../services/extensions.service';
import { Router } from '@angular/router';
import { Title } from '@angular/platform-browser';
@Component({
  selector: 'app-teachers',
  templateUrl: './teachers.component.html',
  styleUrls: ['../../../../../assets/css/tableStyles.css',
              '../../../../../assets/css/paginationStyles.css',
              '../../../../../assets/css/panelStyles.css',
              '../../../../../assets/css/alertStyles.css',
              '../../../../../assets/css/paginationStyles.css',
             ]
})
export class TeachersComponent implements OnInit {
  p: number = 1
  id: string
  ter:string
  searchAlert: boolean
  isInactive: boolean = false
  teachers = []
  extensions = []
  teacher:any[]
  //itemsPerPage: number = 10
  model = {}
  constructor(private _teachersService: TeachersService,
              private _extensionsService: ExtensionsService,
              private router: Router,
              private _titleService: Title) {
                this._titleService.setTitle('Docentes')}

  ngOnInit() {
    this._extensionsService.getExtension().subscribe(data=>{this.extensions = data})
    this.  model = {"extension": localStorage.getItem('extension')}
    this._teachersService.getData('','all',localStorage.getItem('extension')).subscribe(data=>{
      if(!data)
        this.teachers = []
      else
        this.teachers = data
    })
  }

  getId(teacher){
    this.teacher = teacher
  }
  filterData(ter:string,type:string,extension:string){
    this.searchAlert = false
    this._teachersService.getData(ter,type,extension).subscribe(data=>{
      if(ter !='' && !data){
        this.ter = ter
        this.searchAlert = true
        this.teachers = []
      }
      else if(ter =='' && !data){
        this.teachers = []
      }
      else
        this.teachers = data
    })
  }
  Delete(){
    this._teachersService.changeStatus(this.teacher['codeTeacher'],'0').subscribe(resp=>{
      if(resp){
        this.teachers.splice(this.teachers.indexOf(this.teacher),1)
      }
    })
  }
  Edit(teacher){
    this.id = teacher['codeTeacher']
    this.router.navigate(['/editteacher',this.id])
  }
  Activate(teacher){
    this.teacher = teacher
    this._teachersService.changeStatus(teacher['codeTeacher'],'1').subscribe(resp=>{
      if(resp){
        this.teachers.splice(this.teachers.indexOf(this.teacher),1)
      }
    })
  }

  checkInactive(type){
    if (type == 'inactive')
      this.isInactive = true //Show inactives
    else
      this.isInactive = false //Hide inactives
  }

  searchTeacher(ter:string,type:string,extension:string){
      this.ter = ter
      this._teachersService.Search(ter,type,extension).subscribe(data=>{
          if(data.length >0){
            this.searchAlert = false
          }else{
            this.searchAlert = true
          }
          this.teachers = data
        }
      )
  }

}

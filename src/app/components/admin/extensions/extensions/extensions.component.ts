import { Component, OnInit } from '@angular/core';
import { ExtensionsService } from '../../../../services/extensions.service';
import { Router } from '@angular/router';
import { LoaderService } from '../../../../services/loader.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-extensions',
  templateUrl: './extensions.component.html',
  styleUrls: ['../../../../../assets/css/tableStyles.css',
              '../../../../../assets/css/paginationStyles.css',
              '../../../../../assets/css/panelStyles.css',
              '../../../../../assets/css/containerStyles.css'
             ]
})
export class ExtensionsComponent implements OnInit {
  p: number = 1
  id: string
  ter:string
  searchAlert: boolean
  inactive: boolean = false
  isLoader: boolean = false
  extensions = []
  extension:any[]
  itemsPerPage: number = 10
  constructor(private _extensionsService: ExtensionsService,
     private router: Router,
     private _loaderService: LoaderService,
     private _titleService: Title) {
       this._titleService.setTitle('Extensiones')
      }

  ngOnInit() {
   this._loaderService.display(true) //show loader
   this.isLoader = true
   /* Call function getData from service*/
    this._extensionsService.getData('1').subscribe(data=>{
      this.extensions = data //add data
      this._loaderService.display(false)//hide loader
      this.isLoader = false
    })
  }
  getId(extension){
    this.extension = extension;
  }
  getType(type){
    this._extensionsService.getData(type).subscribe(data=>{
      if(!data)
        this.extensions = []
      else
        this.extensions = data
    })
  }
  Search(ter, type){
    this.searchAlert = false //hide search searchAlert
    /*Call function Search from service*/
    this._extensionsService.Search(ter, type).subscribe(
      /*Get response from service*/
      data=>{
        /* Validate response */
        if(!data){
          this.ter = ter //set ter
          this.extensions = [] // clear extensions
          this.searchAlert = true //show search alert
        }
        else
        this.extensions = data // add data response to extensions
      })
    }


  Edit(extension){
   this.router.navigate(['/editextension',extension['idExtension']])
  }
  Delete(){
    this._extensionsService.changeStatus(this.extension['idExtension'],'0').subscribe(data=>{
      if(data){
        this.extensions.splice(this.extensions.indexOf(this.extension),1)
      }
    })
  }
  Activate(extension){
    this.extension = extension
    this._extensionsService.changeStatus(this.extension['idExtension'],'1').subscribe(data=>{
      if(data){
        this.extensions.splice(this.extensions.indexOf(this.extension),1)
      }
    })
  }


}

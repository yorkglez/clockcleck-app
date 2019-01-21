import { Component, OnInit } from '@angular/core';
import { ExtensionsService } from '../../../../services/extensions.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-extensions',
  templateUrl: './extensions.component.html',
  styleUrls: ['../../../../../assets/css/tableStyles.css',
              '../../../../../assets/css/paginationStyles.css',
              '../../../../../assets/css/panelStyles.css'
             ]
})
export class ExtensionsComponent implements OnInit {
  p: number = 1
  id: string
  ter:string
  searchAlert: boolean
  inactive: boolean = false
  extensions = []
  extension:any[]
  itemsPerPage: number = 10
  constructor(private _extensionsService: ExtensionsService, private router: Router) { }

  ngOnInit() {
    this._extensionsService.getExtensions('1').subscribe(data=>{this.extensions = data})
  }
  getId(extension){
    this.extension = extension;
  }
  getType(type){
    this._extensionsService.getExtensions(type).subscribe(data=>{this.extensions = data})
  }
  Search(ter, type){
    this.searchAlert = false
    this._extensionsService.Search(ter, type).subscribe(
      data=>{
        if(!data){
          this.ter = ter
          this.extensions = []
          this.searchAlert = true
        }
        else
            this.extensions = data
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

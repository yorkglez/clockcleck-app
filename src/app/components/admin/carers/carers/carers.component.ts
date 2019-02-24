import { Component, OnInit } from '@angular/core';
import { CarersService, Carer } from '../../../../services/carers.service';
import { Router } from '@angular/router';
import { ExtensionsService } from '../../../../services/extensions.service';
import { LoaderService } from '../../../../services/loader.service';
import { Title } from '@angular/platform-browser';

@Component({
  selector: 'app-carers',
  templateUrl: './carers.component.html',
  styleUrls: ['../../../../../assets/css/tableStyles.css',
              '../../../../../assets/css/paginationStyles.css',
              '../../../../../assets/css/panelStyles.css',
              '../../../../../assets/css/containerStyles.css'
             ]
})

export class CarersComponent implements OnInit {
//[x: string]: any;
  p: number = 1
//  itemsPerPage: number = 10
  id: string
  ter:string
  code:string
  extension: string
  searchAlert: boolean = false
  inactive: boolean = false
  carers = []
  carer: Carer
  extensions: any = []
  model = {'extension':''}
  constructor(private _carersService: CarersService,
              private _loaderService: LoaderService,
              private router: Router,
              private _extensionsService: ExtensionsService,
              private _titleService: Title) {
                this._titleService.setTitle('Carreras')
              }

  ngOnInit() {
    this._loaderService.display(true)// show loader
    /* Call function getData from service */
    this._carersService.getData(localStorage.getItem('extension'),'active').subscribe(data=>{
      this.carers = data //add carers
      this._loaderService.display(false) //hide loader
    })
    /* Call function getExtwension from service*/
    this._extensionsService.getExtension().subscribe(data=>{
      this.extensions = data //add extensionts list
      this.extension =  this.extensions[0].idExtension //set first extension
    })
    this.model = {"extension": localStorage.getItem('extension')}
  }

  showBy(extension,status){
      this._carersService.getData(extension,status).subscribe(data=>{this.carers = data }) //get Extensions
  }

  Edit(carer){
    this.router.navigate(['/editcarer',carer.codeCarer]) //redirect to editcarer
  }

  Activate(carer){
    this.carer = carer //add carer
    /* Call function changeStatus from service*/
    this._carersService.changeStatus(this.carer.codeCarer,'1').subscribe(resp=>{
      /* Validate response*/
      if(resp)
        this.carers.splice(this.carers.indexOf(this.carer),1)
    })
  }

  Search(ter:string, extension:string,status:string){
    this.searchAlert = false
    this._carersService.Search(ter,extension,status).subscribe(data=>{
      if(!data){
        this.ter = ter
        this.carers = []
        this.searchAlert = true
      }
      else
        this.carers = data
    })
  }

  getId(carer){
    this.carer = carer
  }

  Delete(){
    /* Call function changeStatus from service*/
    this._carersService.changeStatus(this.carer.codeCarer,'0').subscribe(resp=>{
      /*Validate response*/
      if(resp)
        this.carers.splice(this.carers.indexOf(this.carer),1) ///remove item from array
    })
  }

}

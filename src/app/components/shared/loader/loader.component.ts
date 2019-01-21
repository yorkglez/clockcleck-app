import { Component, OnInit } from '@angular/core';
import { LoaderService } from '../../../services/loader.service';

@Component({
  selector: 'app-loader',
  templateUrl: './loader.component.html',
  styleUrls: ['./loader.component.css']

})
export class LoaderComponent implements OnInit {
  isLoading :boolean
  constructor(private _loaderService: LoaderService) { }

  ngOnInit() {
    this._loaderService.status.subscribe((val: boolean)=>{
      this.isLoading = val
    })
  }

}

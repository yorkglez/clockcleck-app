import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { UsersService } from '../../../../services/users.service';

@Component({
  selector: 'app-search-users',
  templateUrl: './search-users.component.html',
  styles: []
})
export class SearchUsersComponent implements OnInit {
  ter:string;
  users: any[];
  constructor(private activatedRoute:ActivatedRoute, private _usersService: UsersService) { }

  ngOnInit() {
    this.activatedRoute.params.subscribe( params =>{
      this.ter = params['ter']
    //  this._usersService.searchUser(this.ter).subscribe(data=>{console.log(data)});
    })
  }

}

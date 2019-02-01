import { Component, OnInit } from '@angular/core';
import { Title }     from '@angular/platform-browser';
import { UsersService } from '../../../../services/users.service';
import { Router } from '@angular/router';
import { LoaderService } from '../../../../services/loader.service';

@Component({
  selector: 'app-users',
  templateUrl: './users.component.html',
  styleUrls: ['../../../../../assets/css/tableStyles.css',
              '../../../../../assets/css/panelStyles.css',
              '../../../../../assets/css/paginationStyles.css',
              '../../../../../assets/css/alertStyles.css'
             ]
})

export class UsersComponent implements OnInit {
  p: number = 1
  searchAlert: boolean = false
  users = []
  user:any[]
  ter:string
  message: string
  type: string
  id: string

  constructor(private _usersService: UsersService,
              private _loaderService: LoaderService,
              private _titleService: Title,
              private router: Router) {
                this._titleService.setTitle('Usuarios')
              }


  ngOnInit() {
   this._loaderService.display(true)
    this._usersService.getData().subscribe(data=>{
      this.users = data
      this._loaderService.display(false)
      }
    )
  }

  deleteUser(){
    this._usersService.Delete(this.user['idUser']).subscribe(data=>{
      if(data.success){
        this.users.splice(this.users.indexOf(this.user),1)
      }
    })
  }

  getId(user){
    this.user = user;
  }

  searchUser(ter:string,type:string){
      this._usersService.Search(ter,type).subscribe(data=>{
          this.users = data
          if(this.users.length > 0){
            this.searchAlert= false
          }else{
            this.ter = ter
            this.searchAlert = true
          }
        }
      )
  }
  editUser(user){
      this.id = user['idUser']
      this.router.navigate(['/edituser',this.id])
  }

  getType(type:string){
    this._usersService.getUserbyType(type).subscribe(data=>{
      this.users = data
      if(this.users.length >0){
        this.searchAlert = false
      }else{
        this.searchAlert = true
      }
    });
  }
}

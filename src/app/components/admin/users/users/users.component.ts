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
   this._loaderService.display(true) //Show loader
    /* get user data from service */
   this._usersService.getData().subscribe(data=>{
     if(!data)
      this.users = []
    else
      this.users = data
     this._loaderService.display(false) //Hide loader
  })
}

deleteUser(){
  /* Call function Delete from service*/
  this._usersService.Delete(this.user['idUser']).subscribe(resp=>{
    /* validate response */
    if(resp){
      this.users.splice(this.users.indexOf(this.user),1) //Remove item from array
    }
  })
}

getId(user){
  this.user = user; //add user
}

  searchUser(ter:string,type:string){
    console.log(ter)
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

  Edit(user){
    this.id = user['idUser'] //add user id
    this.router.navigate(['/edituser',this.id]) //redirect to edituser
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

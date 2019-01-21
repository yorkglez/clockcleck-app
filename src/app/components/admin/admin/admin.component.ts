import { Component, OnInit } from '@angular/core';
import { UserService } from '../../../services/user.service';

@Component({
  selector: 'app-admin',
  templateUrl: './admin.component.html',
  styleUrls: ['./admin.component.css']
})
export class AdminComponent implements OnInit {
  message = "Loading...."
  constructor(private user: UserService) { }

  ngOnInit() {
    this.user.getSomeData().subscribe(logged => {
      // this.message = data.message
      console.log(logged)

    })
  }

}

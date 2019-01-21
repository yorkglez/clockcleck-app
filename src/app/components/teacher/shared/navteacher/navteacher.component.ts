import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-navteacher',
  templateUrl: './navteacher.component.html',
  styleUrls: ['../../../../../assets/css/navbarStyles.css']
})
export class NavteacherComponent implements OnInit {
  username: string
  constructor() { }

  ngOnInit() {
    this.username = localStorage.getItem('username')
    
  }

}

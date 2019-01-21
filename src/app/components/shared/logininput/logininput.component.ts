import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-logininput',
  templateUrl: './logininput.component.html',
  styleUrls: ['../../../../assets/css/loginStyles.css']
})
export class LogininputComponent implements OnInit {

  constructor() { }

  @Input() model = {}
  //@Input() error: boolean

  @Output() data = new EventEmitter
  ngOnInit() {
  }

  login(event){
    console.log(this.model)
    this.data.emit({model: this.model})
  }

}

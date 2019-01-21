import { Component, OnInit,Input,Output } from '@angular/core';

@Component({
  selector: 'app-alerts',
  templateUrl: './alerts.component.html',
  styleUrls: []
})
export class AlertsComponent implements OnInit {
  @Input() type: string
  @Input() message: string
  @Input() alertVisible: boolean
  constructor() { }

  ngOnInit() {

  }
}

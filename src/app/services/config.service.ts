import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class ConfigService {

  constructor(private http: HttpClient) { }

  getConfig(): Observable<Config>{
    return this.http.get<Config>('api/queries/Config/getConfig.php')
  }
  Save(model){
    return this.http.post('api/queries/Config/Save.php',JSON.stringify(model))
  }
  Update(model){
    return this.http.post('api/queries/Config/Update.php',JSON.stringify(model))
  }


}
export interface Config {
  durationBreak: string,
  durationModule: string,
  ebreakTime: string,
  endTime: string,
  idConfig: string,
  sbreakTime:string,
  startTime: string
}

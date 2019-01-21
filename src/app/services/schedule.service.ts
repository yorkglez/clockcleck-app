import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class ScheduleService {
  url = 'http://api.malastareas.com.mx/Queries/Schedule/'
  private semesters = ['1','2','3','4','5','6','7','8','9','10']

  constructor(private http: HttpClient) { }
  getHours():Observable<Hours[]>{
    return this.http.get<Hours[]>('api/queries/Schedule/getHoursList.php')
  }
  getSemesters(){
    return this.semesters
  }
  getSubjectsTeacher():Observable<Sc>{
      return this.http.get<Sc>('api/queries/Schedule/getScheduleTeacher.php')
  }
  getScheduleConfig(code){
      return this.http.get<sConfig>('api/queries/Schedule/getScheduleConfig.php',{params:{code:code}})
  }
  getScheduleTeacherbyId(code):Observable<Sc>{
      return this.http.get<Sc>('api/queries/Schedule/getScheduleTeacherbyid.php',{params:{code:code}})
  }

}
export interface  Schedule {
    starTime:string,
    endTime:string,
    day:string,
    subject:string
}
export interface sConfig{
  hours:any[],
  breakTime:number
}
export interface Hours{
  value: string,
  hour: string
}

export interface Sc {
    lunes:any[],
    martes:any[],
    miercoles:any[],
    jueves:any[],
    viernes:any[]
}

export interface Hour{
  startTime:string,
  endTime:string
}

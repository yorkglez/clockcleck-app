import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { map } from 'rxjs/internal/operators/map';

@Injectable({
  providedIn: 'root'
})
export class ReportsService {

  constructor(private http: HttpClient) {

  }

  getReports(model): Observable<Report[]>{
    return this.http.post<Report[]>('api/queries/Report/getReports.php',JSON.stringify(model))
  }

  getselectTeacher(ex): Observable<TeacherSelect[]>{
    return this.http.get<TeacherSelect[]>('api/queries/Helpers/getselectTeacher.php',{params:{ex:ex}})
  }

  saveChanges(id,note,type){
    return this.http.post('api/queries/Attendance/saveChanges.php',{id: id, note: note, type: type})
  }

  generateReportPDF(){
    var headers = new Headers();
    headers.append('responseType', 'arraybuffer');
    return this.http.get('api/queries/Report/generatePDF.php')
    .pipe(map(res => new Blob([res],{ type: 'application/pdf' })))

  }


}
export interface Report{
  codeTeacher: string,
  nameTeacher: string,
  type:  string,
  nameSubject: string,
  startTime: string,
  endTime: string,
  date_At: string,
  notes: string
}
export interface TeacherSelect{
  codeTeacher: string,
  name: string
}

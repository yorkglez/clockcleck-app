import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CarersService {
  url = 'http://api.malastareas.com.mx/Queries/Carer/';
  constructor(private http: HttpClient) { }

  getData(extension:string,status:string): Observable<Carer[]>{
    return this.http.get<Carer[]>('api/queries/Carer/getCarers.php',{params:{extension: extension,status: status}})
  }
  Search(ter:string,extension:string,status:string): Observable<Carer[]>{
    ter = ter.toLowerCase()
    return this.http.get<Carer[]>('api/queries/Carer/searchCarer.php',{params:{ter: ter, extension: extension,status: status}})
  }
  Save(model) {
    return this.http.post('api/queries/Carer/saveCarer.php',JSON.stringify(model))
  }

  getSelectCarers(ex): Observable<carersSelect[]>{
    return this.http.get<carersSelect[]>('api/queries/Carer/getSelectCarers.php',{params: {extension: ex}})
  }

  getSelectCarersTeacher(ex,code): Observable<carersSelect[]>{
    return this.http.get<carersSelect[]>('api/queries/Carer/getSelectCarersTeacher.php',{params: {extension: ex, code: code}})
  }
  Update(model, id) {
    return this.http.post('api/queries/Carer/updateCarer.php',{model: JSON.stringify(model), id: id})
  }

  changeStatus(code:string,status:string){
    return this.http.post('api/queries/Carer/changeStatus.php',{code: code,status: status})
  }

  getCarerbyType(status:string){
    return this.http.get<Carer[]>('api/queries/Carer/getDatabyType.php',{params:{type:status}})
  }

  getDatabyId(id:string):Observable<Carer[]>{
    return this.http.get<Carer[]>('api/queries/Carer/getCarer.php',{params:{id:id}})
  }


}
export interface Carer{
  codeCarer: string,
  name: string,
  alias: string,
  idExtension: string
}
export interface carersSelect{
  id: string,
  alias: string
}

import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
@Injectable({
  providedIn: 'root'
})
export class ExtensionsService {
  url = 'http://api.malastareas.com.mx/Queries/Extension/'
  constructor(private http: HttpClient) { }

  getExtension(): Observable<Extension[]>{
    return this.http.get<Extension[]>('api/queries/Extension/getExtension.php')
  }
  getExtensionbyId(id): Observable<Extension>{
    return this.http.get<Extension>('api/queries/Extension/getExtensionbyId.php',{params:{id: id}})
  }
  getExtensions(status): Observable<Extension[]>{
    return this.http.get<Extension[]>('api/queries/Extension/getExtensions.php',{params: {status: status}})
  }
  saveExtension(model){
    return this.http.post('api/queries/Extension/saveExtension.php',JSON.stringify(model))
  }
  Update(model){
    return this.http.post('api/queries/Extension/updateExtension.php',JSON.stringify(model))
  }
  Search(ter:string,status:string){
    return this.http.get<Extension[]>('api/queries/Extension/Search.php',{params: {ter: ter, status: status}})
  }
  changeStatus(id,status){
    return this.http.post('api/queries/Extension/changeStatus.php',{id: id,status: status})
  }
}

 interface Extension {
    idExtension: string,
    name: string,
    address: string,
    city: string,
    status: string
}

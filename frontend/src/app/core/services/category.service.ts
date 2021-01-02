import { Injectable } from '@angular/core';

import { BehaviorSubject, Observable } from 'rxjs';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';

import { NotificationService } from '@core/services/notification.service';

import { Category } from '@core/interfaces/category.interface';

import { baseUrl } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  public categories$ = new BehaviorSubject<Category[]>([]);
  
  constructor(
    private http: HttpClient,
    private ns: NotificationService
  ) { }

  public getCategories(): void {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.get<Category[]>(`${baseUrl}/categories`, {headers: header}).subscribe(
      c => {
        this.categories$.next(c);
      }
    )
  }

  public addCategory(category: Category) {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.post(`${baseUrl}/categories`, category, {headers: header}).subscribe(
      resp => {
        
      }
    )
  }
}

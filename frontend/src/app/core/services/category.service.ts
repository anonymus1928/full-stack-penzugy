import { Injectable } from '@angular/core';

import { BehaviorSubject, Observable } from 'rxjs';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';

import { NotificationService } from '@core/services/notification.service';

import { Category } from '@core/interfaces/category.interface';

import { baseUrl } from 'src/environments/environment';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  public categories$ = new BehaviorSubject<Category[]>([]);
  
  constructor(
    private http: HttpClient,
    private ns: NotificationService,
    private router: Router
  ) { }

  async asyncGetCategories(): Promise<Category[]> {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    const categories: Category[] = await this.http.get<Category[]>(`${baseUrl}/categories`, {headers: header}).toPromise();
    return categories;
  }

  public getCategories(): void {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.get<Category[]>(`${baseUrl}/categories`, {headers: header}).subscribe(
      c => {
        console.log(c['category']);
        this.categories$.next(c['category']);
      },
      error => {
        this.ns.show('Váratlan hiba történt!');
        console.error(error);
        if(error.status == 401) {
          localStorage.removeItem('fsPT')
          this.router.navigate(['/']);
        }
      }
    )
  }

  public addCategory(category: Category) {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.post(`${baseUrl}/categories`, category, {headers: header}).subscribe(
      resp => {
        console.log(resp);
        this.categories$.next(this.categories$.getValue().concat([resp['category']]));
      },
      error => {
        this.ns.show('Az új kategória létrehozása sikertelen.');
        console.error(error);
      }
    )
  }

  public updateCategory(category: Category, id: number) {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.patch(`${baseUrl}/categories/${id}`, category, {headers: header}).subscribe(
      resp => {
        console.log(resp);
        this.categories$.next(this.categories$.getValue().filter(cat => cat.id !== id).concat([resp['category']]));
      },
      error => {
        this.ns.show('A kategória módosítása sikertelen.');
        console.error(error);
      }
    )
  }

  public deleteCategory(id: number) {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.delete(`${baseUrl}/categories/${id}`, {headers: header}).subscribe(
      resp => {
        console.log(resp);
        this.categories$.next(this.categories$.getValue().filter(cat => cat.id !== id));
      },
      error => {
        this.ns.show('A kategória törlése sikertelen.');
        console.error(error);
      }
    )
  }
}

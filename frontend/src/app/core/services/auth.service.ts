import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { BehaviorSubject, Observable } from 'rxjs';

import { NotificationService } from '@core/services/notification.service';

import { User } from '@core/interfaces/user.interface';
import { Router } from '@angular/router';
import { baseUrl } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  isLogin$ = new BehaviorSubject<boolean>(this.hasToken());

  httpOptions = {
    headers: new HttpHeaders({
      'Content-Type': 'application/json',
      'Authorization': ''
    })
  }

  constructor(
    private http: HttpClient,
    private router: Router,
    private ns: NotificationService
  ) { }

  isLoggedIn(): Observable<boolean> {
    return this.isLogin$.asObservable();
  }

  register(user: User): void {
    this.http.post<User>(`${baseUrl}/api/register`, user, this.httpOptions).subscribe(
      data => {
        localStorage.setItem('fsPT', data['token']);
        this.isLogin$.next(true);
        this.ns.show('Sikeres regisztráció!')
        this.router.navigate(['/transactions']);
      },
      error => {
        this.ns.show('HIBA! A regisztráció sikertelen!');
        console.log(error);
      }
    )
  }

  login(user: User): void {
    this.http.post<User>(`${baseUrl}/api/login`, user, this.httpOptions).subscribe(
      data => {
        localStorage.setItem('fsPT', data['token']);
        this.isLogin$.next(true);
        this.ns.show('Sikeres bejelentkezés!');
        this.router.navigate(['/transactions']);
      },
      error => {
        this.ns.show('HIBA! Sikertelen bejelentkezés!');
        console.error(error);
        
      }
    );
  }

  logout(): void {
    localStorage.removeItem('fsPT');
    this.isLogin$.next(false);
    this.ns.show('Sikeres kijelentkezés!');
    this.router.navigate(['/']);
  }

  protected hasToken(): boolean {
    return !!localStorage.getItem('fsPT');
  }
}

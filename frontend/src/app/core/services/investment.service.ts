import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Investment } from '@core/interfaces/investment.interface';
import { BehaviorSubject } from 'rxjs';
import { baseUrl } from 'src/environments/environment';
import { NotificationService } from './notification.service';

@Injectable({
  providedIn: 'root'
})
export class InvestmentService {
  public investments$ = new BehaviorSubject<Investment[]>([]);

  constructor(
    private http: HttpClient,
    private ns: NotificationService,
    private router: Router
  ) { }

  public getInvestments(): void {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.get<Investment[]>(`${baseUrl}/investments`, {headers: header}).subscribe(
      i => {
        console.log(i['investments']);
        this.investments$.next(i['investments']);
      },
      error => {
        this.ns.show('Váratlan hiba történt!');
        console.error(error);
      }
    )
  }

  public addInvestment(investment: Investment) {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.post(`${baseUrl}/investments`, investment, {headers: header}).subscribe(
      resp => {
        console.log(resp);
        this.router.navigate(['/refresh', {skipLocationChange: true}]).then(() => {
          this.router.navigate(['/investments']);
        });
      },
      error => {
        this.ns.show('Az új befektetési részvény létrehozása sikertelen.');
        console.error(error);
      }
    )
  }

  public updateInvestment(investment: Investment, id: number) {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.patch(`${baseUrl}/investments/${id}`, investment, {headers: header}).subscribe(
      resp => {
        console.log(resp);
        this.router.navigate(['/refresh', {skipLocationChange: true}]).then(() => {
          this.router.navigate(['/investments']);
        });
      },
      error => {
        this.ns.show('A befektetési részvény módosítása sikertelen.');
        console.error(error);
      }
    )
  }

  public deleteInvestment(id: number) {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.delete(`${baseUrl}/investments/${id}`, {headers: header}).subscribe(
      resp => {
        console.log(resp);
        this.investments$.next(this.investments$.getValue().filter(inv => inv.id !== id));
      },
      error => {
        this.ns.show('A befektetési részvény törlése sikertelen.');
        console.error(error);
      }
    )
  }
}

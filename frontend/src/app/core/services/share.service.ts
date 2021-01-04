import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Share } from '@core/interfaces/share.interface';
import { BehaviorSubject } from 'rxjs';
import { baseUrl } from 'src/environments/environment';
import { NotificationService } from './notification.service';

@Injectable({
  providedIn: 'root'
})
export class ShareService {
  public shares$ = new BehaviorSubject<Share[]>([]);

  constructor(
    private http: HttpClient,
    private ns: NotificationService,
    private router: Router
  ) { }

  public getShares(): void {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.get<Share[]>(`${baseUrl}/shares`, {headers: header}).subscribe(
      s => {
        console.log(s['share']);
        this.shares$.next(s['share']);
        console.log(this.shares$.getValue());
        
      },
      error => {
        this.ns.show('Váratlan hiba történt!');
        console.error(error);
      }
    )
  }

  public downloadShare(symbol: string): void {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.put<Share>(`${baseUrl}/shares/${symbol}`, {}, {headers: header}).subscribe(
      s => {
        this.router.navigate(['/refresh', {skipLocationChange: true}]).then(() => {
          this.router.navigate(['/shares']);
        });
        this.ns.show('A részvénykibocsátó lekérése sikeres!');
      },
      error => {
        this.ns.show('Váratlan hiba történt!');
        console.error(error);
      }
    );
  }

  async asyncGetShares(): Promise<Share[]> {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    const shares: Share[] = await this.http.get<Share[]>(`${baseUrl}/shares`, {headers: header}).toPromise();
    return shares;
  }
}

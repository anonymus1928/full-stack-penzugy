import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { Transaction } from '@core/interfaces/transaction.interface';
import { BehaviorSubject } from 'rxjs';
import { baseUrl } from 'src/environments/environment';
import { NotificationService } from './notification.service';

@Injectable({
  providedIn: 'root'
})
export class TransactionService {
  public transactions$ = new BehaviorSubject<Transaction[]>([]);

  constructor(
    private http: HttpClient,
    private ns: NotificationService,
    private router: Router
  ) { }

  public getTransactions(): void {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.get<Transaction[]>(`${baseUrl}/transactions`, {headers: header}).subscribe(
      t => {
        this.transactions$.next(t['transaction']);
      },
      error => {
        this.ns.show('Váratlan hiba tölrtént!');
        console.error(error);
      }
    );
  }

  public addTransaction(transaction: Transaction, tmpCats: number[]): void {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    console.log(tmpCats);
    
    const body = {
      amount: transaction.amount,
      name: transaction.name,
      description: transaction.description,
      due: transaction.due,
      categories: tmpCats
    };
    this.http.post(`${baseUrl}/transactions`, body, {headers: header}).subscribe(
      resp => {
        console.log(resp);
        this.router.navigate(['/refresh', {skipLocationChange: true}]).then(() => {
          this.router.navigate(['/transactions']);
        });
      },
      error => {
        this.ns.show('Az új tranzakció létrehozása sikertelen.');
        console.error(error);
      }
    );
  }

  public updateTransaction(transaction: Transaction, id: number, tmpCats: number[]) {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    const body = {
      amount: transaction.amount,
      name: transaction.name,
      description: transaction.description,
      due: transaction.due,
      categories: tmpCats
    };
    this.http.patch(`${baseUrl}/transactions/${id}`, body, {headers: header}).subscribe(
      resp => {
        console.log(resp);
        this.router.navigate(['/refresh', {skipLocationChange: true}]).then(() => {
          this.router.navigate(['/transactions']);
        });
      },
      error => {
        this.ns.show('A tranzakció módosítása sikertelen.');
        console.error(error);
      }
    )
  }

  public deleteTransaction(id: number) {
    const header = new HttpHeaders().set(
      'Authorization', `Bearer ${localStorage.getItem('fsPT')}`
    );
    this.http.delete(`${baseUrl}/transactions/${id}`, {headers: header}).subscribe(
      resp => {
        console.log(resp);
        this.transactions$.next(this.transactions$.getValue().filter(cat => cat.id !== id));
      },
      error => {
        this.ns.show('A tranzakció törlése sikertelen.');
        console.error(error);
      }
    )
  }
}

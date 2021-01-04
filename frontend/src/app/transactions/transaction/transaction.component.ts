import { Component, Input } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { Transaction } from '@core/interfaces/transaction.interface';
import { TransactionService } from '@core/services/transaction.service';
import { AddEditTransactionComponent } from '../add-edit-transaction/add-edit-transaction.component';

@Component({
  selector: 'app-transaction',
  templateUrl: './transaction.component.html',
  styleUrls: ['./transaction.component.scss']
})
export class TransactionComponent {

  @Input() transaction: Transaction = null;

  constructor(
    public ts: TransactionService,
    public dialog: MatDialog
  ) { }
  
  deleteTransaction(id: number): void {
    this.ts.deleteTransaction(id);
  }

  openAddEditTransactionDialog(): void {
    const dialogRef = this.dialog.open(AddEditTransactionComponent, {
      width: '1000px',
      data: this.transaction
    });
  }
  
  formatDate(date: any): string {
    let d = new Date(date);
    let month = '' + (d.getMonth() + 1);
    let day = '' + d.getDate();
    let year = d.getFullYear();
    if(month.length < 2) {
      month = '0' + month;
    }
    if(day.length < 2) {
      day = '0' + day;
    }
    return [year, month, day].join('-');
  }
}

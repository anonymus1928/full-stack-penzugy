import { Component, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { TransactionService } from '@core/services/transaction.service';
import { AddEditTransactionComponent } from './add-edit-transaction/add-edit-transaction.component';

@Component({
  selector: 'app-transactions',
  templateUrl: './transactions.component.html',
  styleUrls: ['./transactions.component.scss']
})
export class TransactionsComponent implements OnInit {

  constructor(
    public ts: TransactionService,
    public dialog: MatDialog
  ) { }

  openAddEditTransactionDialog(): void {
    const dialogRef = this.dialog.open(AddEditTransactionComponent, {
      width: '1000px'
    })
  }

  ngOnInit(): void {
    this.ts.getTransactions();
  }

}

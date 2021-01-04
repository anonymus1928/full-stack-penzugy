import { Component, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { InvestmentService } from '@core/services/investment.service';
import { AddEditInvestmentComponent } from './add-edit-investment/add-edit-investment.component';

@Component({
  selector: 'app-investments',
  templateUrl: './investments.component.html',
  styleUrls: ['./investments.component.scss']
})
export class InvestmentsComponent implements OnInit {

  constructor(
    public is: InvestmentService,
    public dialog: MatDialog
  ) { }

  openAddEditInvestmentDialog(): void {
    const dialogRef = this.dialog.open(AddEditInvestmentComponent, {
      width: '1000px'
    })
  }

  ngOnInit(): void {
    this.is.getInvestments();
  }

}

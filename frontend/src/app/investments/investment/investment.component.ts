import { Component, Input, OnInit } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { Investment } from '@core/interfaces/investment.interface';
import { InvestmentService } from '@core/services/investment.service';
import { AddEditInvestmentComponent } from '../add-edit-investment/add-edit-investment.component';

@Component({
  selector: 'app-investment',
  templateUrl: './investment.component.html',
  styleUrls: ['./investment.component.scss']
})
export class InvestmentComponent {

  @Input() investment: Investment = null;

  constructor(
    public is: InvestmentService,
    public dialog: MatDialog
  ) { }

  deleteInvestment(id: number): void {
    this.is.deleteInvestment(id);
  }

  openAddEditInvestmentDialog(): void {
    const dialogRef = this.dialog.open(AddEditInvestmentComponent, {
      width: '1000px',
      data: this.investment
    })
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

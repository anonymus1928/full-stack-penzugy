import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Investment } from '@core/interfaces/investment.interface';
import { InvestmentService } from '@core/services/investment.service';
import { NotificationService } from '@core/services/notification.service';

@Component({
  selector: 'app-add-edit-investment',
  templateUrl: './add-edit-investment.component.html',
  styleUrls: ['./add-edit-investment.component.scss']
})
export class AddEditInvestmentComponent implements OnInit {

  public investmentForm: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddEditInvestmentComponent>,
    public is: InvestmentService,
    public ns: NotificationService,
    @Inject(MAT_DIALOG_DATA) public data: Investment
  ) {
    if(!data) {
      this.investmentForm = this.formBuilder.group({
        price: [null, Validators.required],
        amount: [null, Validators.required],
        date: [null, Validators.required],
        symbol: [null, Validators.required]
      })
    } else {
      this.investmentForm = this.formBuilder.group({
        price: [data.price, Validators.required],
        amount: [data.amount, Validators.required],
        date: [data.date, Validators.required],
        symbol: [data.share.symbol, Validators.required]
      });
    }
  }

  ngOnInit(): void {
  }

  addInvestment(form: FormGroup): void {
    if(form.valid) {
      this.is.addInvestment(<Investment>form.value);
      this.investmentForm.reset();
      this.dialogRef.close();
      this.ns.show('Befektetési részvény rögzítve!');
    } else {
      this.ns.show('A megadott adatok hibásak!');
    }
  }

  updateInvestment(form: FormGroup, id: number): void {
    if(form.valid) {
      this.is.updateInvestment(<Investment>form.value, id);
      this.investmentForm.reset();
      this.dialogRef.close();
      this.ns.show('Befektetési részvény módosítása sikeres!');
    } else {
      this.ns.show('A megadott adatok hibásak!');
    }
  }

}

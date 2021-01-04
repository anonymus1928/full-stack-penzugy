import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Transaction } from '@core/interfaces/transaction.interface';
import { Category } from '@core/interfaces/category.interface';
import { NotificationService } from '@core/services/notification.service';
import { TransactionService } from '@core/services/transaction.service';
import { CategoryService } from '@core/services/category.service';
import { MatCheckboxChange } from '@angular/material/checkbox';

@Component({
  selector: 'app-add-edit-transaction',
  templateUrl: './add-edit-transaction.component.html',
  styleUrls: ['./add-edit-transaction.component.scss']
})
export class AddEditTransactionComponent implements OnInit {

  public transactionForm: FormGroup;
  public categories: Category[];
  private checkedCategories: number[] = [];

  constructor(
    private formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddEditTransactionComponent>,
    public ts: TransactionService,
    public cs: CategoryService,
    private ns: NotificationService,
    @Inject(MAT_DIALOG_DATA) public data: Transaction
  ) {
    if(!data) {
      this.transactionForm = this.formBuilder.group({
        name: [null, Validators.required],
        description: null,
        amount: [null, Validators.required],
        due: [null, Validators.required]
      });
    } else {
      console.log(data);
      data.categories.forEach(cat => this.checkedCategories.push(cat.id));
      this.transactionForm = this.formBuilder.group({
        name: [data.name, Validators.required],
        description: data.description,
        amount: [data.amount, Validators.required],
        due: [data.due, Validators.required]
      });
    }
  }

  ngOnInit(): void {
    console.log('categories');
    this.cs.asyncGetCategories().then((cat: Category[]) => {
      this.categories = cat['category'];
    });
  }

  addTransaction(form: FormGroup): void {
    if(form.valid) {
      this.ts.addTransaction(<Transaction>form.value, this.checkedCategories);
      this.transactionForm.reset();
      this.dialogRef.close();
      this.ns.show('Tranzakció létrehozása sikeres!');
    } else {
      this.ns.show('A megadott adatok hibásak!');
    }
  }

  updateTransaction(form: FormGroup, id: number): void {
    if(form.valid) {
      this.ts.updateTransaction(<Transaction>form.value, id, this.checkedCategories);
      console.log(this.checkedCategories);
      
      this.transactionForm.reset();
      this.dialogRef.close();
      this.ns.show('Tranzakció módosítása sikeres!');
    } else {
      this.ns.show('A megadott adatok hibásak!');
    }
  }

  categoryChange(event: MatCheckboxChange) {
    if(this.checkedCategories.includes(parseInt(event.source.value))) {
      this.checkedCategories.splice(this.checkedCategories.indexOf(parseInt(event.source.value)), 1);
    } else {
      this.checkedCategories.push(parseInt(event.source.value));
    }
  }
}

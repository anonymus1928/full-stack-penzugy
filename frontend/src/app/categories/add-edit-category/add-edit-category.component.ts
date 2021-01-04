import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Category } from '@core/interfaces/category.interface';
import { CategoryService } from '@core/services/category.service';
import { NotificationService } from '@core/services/notification.service';

@Component({
  selector: 'app-add-edit-category',
  templateUrl: './add-edit-category.component.html',
  styleUrls: ['./add-edit-category.component.scss']
})
export class AddEditCategoryComponent implements OnInit {

  public categoryForm: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    public dialogRef: MatDialogRef<AddEditCategoryComponent>,
    public cs: CategoryService,
    private ns: NotificationService,
    @Inject(MAT_DIALOG_DATA) public data: Category
    ) {
      if(!data) {
        this.categoryForm = this.formBuilder.group({
          name: [null, Validators.required],
          description: null
        });
      } else {
        this.categoryForm = this.formBuilder.group({
          name: [data.name, Validators.required],
          description: data.description
        });
      }
    }

  ngOnInit(): void {
  }

  addCategory(form: FormGroup): void {
    if(form.valid) {
      this.cs.addCategory(<Category>form.value);
      this.categoryForm.reset();
      this.dialogRef.close();
      this.ns.show('Kategória létrehozása sikeres!');
    } else {
      this.ns.show('A megadott adatok hibásak!');
    }
  }

  updateCategory(form: FormGroup, id: number): void {
    if(form.valid) {
      this.cs.updateCategory(<Category>form.value, id);
      this.categoryForm.reset();
      this.dialogRef.close();
      this.ns.show('Kategória módosítása sikeres!');
    } else {
      this.ns.show('A megadott adatok hibásak!');
    }
  }
}

import { Component, Inject, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, FormControl, Validators } from '@angular/forms';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { Category } from '@core/interfaces/category.interface';

import { CategoryService } from '@core/services/category.service';

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
    @Inject(MAT_DIALOG_DATA) public data: Category,
    public cs: CategoryService
    ) {
      this.categoryForm = this.formBuilder.group({
        name: [null, Validators.required],
        description: null
      });
    }

  ngOnInit(): void {
  }

  addIssue(form: FormGroup): void {
    
  }

}

import { Component, OnInit } from '@angular/core';
import { MatDialog } from "@angular/material/dialog";
import { CategoryService } from '@core/services/category.service';

import { Category } from '@core/interfaces/category.interface';
import { AddEditCategoryComponent } from './add-edit-category/add-edit-category.component';

@Component({
  selector: 'app-categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.scss']
})
export class CategoriesComponent implements OnInit {

  constructor(
    public cs: CategoryService,
    public dialog: MatDialog
  ) { }

  openAddEditCategoryDialog(): void {
    const dialogRef = this.dialog.open(AddEditCategoryComponent, {
      width: '1000px'
    })
  }

  ngOnInit(): void {
    this.cs.getCategories();
  }

}

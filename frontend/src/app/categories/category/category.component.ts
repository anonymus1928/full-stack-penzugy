import { Component, Input } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';

import { Category } from '@core/interfaces/category.interface';
import { CategoryService } from '@core/services/category.service';
import { AddEditCategoryComponent } from '../add-edit-category/add-edit-category.component';

@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.scss']
})
export class CategoryComponent {

  @Input() category: Category = null;

  constructor(
    public cs: CategoryService,
    public dialog: MatDialog
  ) { }

  deleteCategory(id: number): void {
    this.cs.deleteCategory(id);
  }

  openAddEditCategoryDialog(): void {
    const dialogRef = this.dialog.open(AddEditCategoryComponent, {
      width: '1000px',
      data: this.category
    })
  }

}

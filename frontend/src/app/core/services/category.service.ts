import { Injectable } from '@angular/core';
import { Category } from '@core/interfaces/category.interface';

@Injectable({
  providedIn: 'root'
})
export class CategoryService {
  categories: Category[] = [
    { id: 1, name: 'Category #1', description: 'Description of Category #1', created_at: 1609584184, updated_at: 1609584184, uid: -1},
    { id: 2, name: 'Category #2', description: 'Description of Category #2', created_at: 1609584184, updated_at: 1609584184, uid: -1},
    { id: 3, name: 'Category #3', description: 'Description of Category #3', created_at: 1609584184, updated_at: 1609584184, uid: -1}
  ];
  constructor() { }

  public getCategories(): Category [] {
    return this.categories;
  }

  
}

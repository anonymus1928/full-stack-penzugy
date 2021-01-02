import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { MatSnackBarModule } from '@angular/material/snack-bar';
import { CategoryService } from "@core/services/category.service";

@NgModule({
    declarations: [],
    imports: [
        CommonModule,
        MatSnackBarModule
    ],
    providers: [
        CategoryService
    ]
})
export class CoreModule { }
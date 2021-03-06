


import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http'

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { TransactionsComponent } from './transactions/transactions.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

import { MatExpansionModule } from '@angular/material/expansion';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatIconModule } from '@angular/material/icon';
import { MatButtonModule } from '@angular/material/button';
import { TransactionComponent } from './transactions/transaction/transaction.component';
import { MenuComponent } from './menu/menu.component';
import { MatListModule } from '@angular/material/list';
import { SharesComponent } from './shares/shares.component';
import { InvestmentsComponent } from './investments/investments.component';
import { InvestmentComponent } from './investments/investment/investment.component';
import { MatGridListModule } from '@angular/material/grid-list';
import { MatCardModule } from '@angular/material/card';
import { MatDividerModule } from '@angular/material/divider';
import { CategoriesComponent } from './categories/categories.component';
import { CategoryComponent } from './categories/category/category.component';
import { AddEditCategoryComponent } from './categories/add-edit-category/add-edit-category.component';
import { MatDialogModule } from '@angular/material/dialog';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatInputModule } from "@angular/material/input";
import { MatSelectModule } from '@angular/material/select';
import { MatTooltipModule } from '@angular/material/tooltip';
import { SigninComponent } from './auth/signin/signin.component';
import { AuthComponent } from './auth/auth.component';
import { SignupComponent } from './auth/signup/signup.component';
import { MatSnackBarModule } from '@angular/material/snack-bar';
import { MatTabsModule } from '@angular/material/tabs';
import { FlexLayoutModule } from '@angular/flex-layout';
import { MatChipsModule } from '@angular/material/chips';
import { MatNativeDateModule, MatRippleModule, MAT_DATE_LOCALE } from '@angular/material/core';
import { MatAutocompleteModule } from '@angular/material/autocomplete';
import { MatPasswordStrengthModule } from '@angular-material-extensions/password-strength';
import { PagenotfoundComponent } from './pagenotfound/pagenotfound.component';
import { AuthGuard } from '@core/guards/auth.guard';
import { AddEditTransactionComponent } from './transactions/add-edit-transaction/add-edit-transaction.component';
import { MatDatepickerModule } from '@angular/material/datepicker';
import { MatCheckboxModule } from '@angular/material/checkbox';
import { MatTableModule } from '@angular/material/table';
import { MatPaginatorModule } from '@angular/material/paginator';
import { MatSortModule } from '@angular/material/sort';
import { NgxChartsModule } from '@swimlane/ngx-charts';
import { AddEditInvestmentComponent } from './investments/add-edit-investment/add-edit-investment.component';


@NgModule({
  declarations: [
    AppComponent,
    TransactionsComponent,
    TransactionComponent,
    MenuComponent,
    SharesComponent,
    InvestmentsComponent,
    InvestmentComponent,
    CategoriesComponent,
    CategoryComponent,
    AddEditCategoryComponent,
    SigninComponent,
    AuthComponent,
    SignupComponent,
    PagenotfoundComponent,
    AddEditTransactionComponent,
    AddEditInvestmentComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    BrowserAnimationsModule,
    MatExpansionModule,
    MatToolbarModule,
    MatSidenavModule,
    MatIconModule,
    MatButtonModule,
    MatListModule,
    MatGridListModule,
    MatCardModule,
    MatDividerModule,
    MatDialogModule,
    FormsModule,
    ReactiveFormsModule,
    MatFormFieldModule,
    MatInputModule,
    MatSelectModule,
    MatTooltipModule,
    HttpClientModule,
    MatSnackBarModule,
    MatTabsModule,
    FlexLayoutModule,
    MatChipsModule,
    MatRippleModule,
    MatAutocompleteModule,
    MatPasswordStrengthModule,
    MatDatepickerModule,
    MatNativeDateModule,
    MatCheckboxModule,
    MatTableModule,
    MatPaginatorModule,
    MatSortModule,
    NgxChartsModule
  ],
  providers: [
    AuthGuard,
    {provide: MAT_DATE_LOCALE, useValue: 'hu-HU'}
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }

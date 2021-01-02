import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { SharesComponent } from './shares/shares.component';
import { InvestmentsComponent } from './investments/investments.component';
import { TransactionsComponent } from './transactions/transactions.component';
import { CategoriesComponent } from './categories/categories.component';
import { AuthComponent } from './auth/auth.component';

const routes: Routes = [
  { path: '', component: AuthComponent },
  { path: 'transactions', component: TransactionsComponent },
  { path: 'categories', component: CategoriesComponent },
  { path: 'investments', component: InvestmentsComponent },
  { path: 'shares', component: SharesComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

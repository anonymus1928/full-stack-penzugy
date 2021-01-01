import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { SharesComponent } from './shares/shares.component';
import { InvestmentsComponent } from './investments/investments.component';

import { TransactionsComponent } from './transactions/transactions.component';

const routes: Routes = [
  { path: 'transactions', component: TransactionsComponent },
  { path: 'investments', component: InvestmentsComponent },
  { path: 'shares', component: SharesComponent }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

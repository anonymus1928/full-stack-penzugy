import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { SharesComponent } from './shares/shares.component';
import { InvestmentsComponent } from './investments/investments.component';
import { TransactionsComponent } from './transactions/transactions.component';
import { CategoriesComponent } from './categories/categories.component';
import { AuthComponent } from './auth/auth.component';
import { PagenotfoundComponent } from './pagenotfound/pagenotfound.component';
import { AuthGuard } from '@core/guards/auth.guard';

const routes: Routes = [
  { path: '', component: AuthComponent },
  { path: 'transactions', component: TransactionsComponent, canActivate: [AuthGuard] },
  { path: 'categories', component: CategoriesComponent, canActivate: [AuthGuard] },
  { path: 'investments', component: InvestmentsComponent, canActivate: [AuthGuard] },
  { path: 'shares', component: SharesComponent, canActivate: [AuthGuard] },
  { path: 'shares/:filterName', component: SharesComponent, canActivate: [AuthGuard] },
  { path: '404', component: PagenotfoundComponent },
  { path: '**', redirectTo: '404', pathMatch: 'full' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }

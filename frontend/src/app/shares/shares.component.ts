import { Component, ViewChild } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ShareService } from '@core/services/share.service';
import { MatPaginator } from '@angular/material/paginator';
import { MatSort } from '@angular/material/sort';
import { MatTableDataSource } from '@angular/material/table';
import { Share } from '@core/interfaces/share.interface';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { NotificationService } from '@core/services/notification.service';
import { animate, state, style, transition, trigger } from '@angular/animations';

@Component({
  selector: 'app-shares',
  templateUrl: './shares.component.html',
  styleUrls: ['./shares.component.scss'],
  animations: [
    trigger('detailExpand', [
      state('collapsed', style({height: '0px', minHeight: '0px'})),
      state('expanded', style({height: '*'})),
      transition('expanded <=> collapsed', animate('225ms cubic-bezier(0.4, 0.0, 0.2, 1)'))
    ])
  ]
})
export class SharesComponent {

  public addShareForm: FormGroup;

  displayedColumns: string[] = ['symbol', 'name', 'exchange', 'currency'];
  expandedElement: Share | null;
  dataSource: MatTableDataSource<Share>;

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;

  constructor(
    private formBuilder: FormBuilder,
    public ss: ShareService,
    private route: ActivatedRoute,
    private ns: NotificationService
  ) {
    this.addShareForm = this.formBuilder.group({
      symbol: [null, Validators.required]
    });

    let tmpData: Share[] = [];
    this.ss.asyncGetShares().then((s: Share[]) => {
      this.dataSource = new MatTableDataSource(s['share']);
      this.dataSource.paginator = this.paginator;
      this.dataSource.sort = this.sort;
    });
  }

  addShare(form: FormGroup): void {
    if(form.valid) {
      this.ss.downloadShare(form.value['symbol']);
      this.addShareForm.reset();
    } else {
      this.ns.show('A megadott szimbólum hibás!');
    }
  }

  applyFilter(event: Event) {
    const filterValue = (event.target as HTMLInputElement).value;
    this.dataSource.filter = filterValue.trim().toLowerCase();

    if(this.dataSource.paginator) {
      this.dataSource.paginator.firstPage();
    }
  }
}

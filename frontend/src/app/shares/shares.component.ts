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

  addShareForm: FormGroup;

  filterInputText: string;

  displayedColumns: string[] = ['symbol', 'name', 'exchange', 'currency'];
  expandedElement: Share | null;
  dataSource: MatTableDataSource<Share>;

  multi: any[];
  legend: boolean = true;
  animations: boolean = true;
  xAxis: boolean = true;
  yAxis: boolean = true;
  timeline: boolean = true;
  autoScale: boolean = true;
  colorScheme = {
    domain: ['#5AA454', '#E44D25', '#CFC0BB', '#7aa3e5', '#a8385d', '#aae3f5']
  }

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

    this.ss.asyncGetShares().then((s: Share[]) => {
      this.dataSource = new MatTableDataSource(s['share']);
      this.dataSource.paginator = this.paginator;
      this.dataSource.sort = this.sort;
      
      
      this.route.params.subscribe(params => {
        if(params.filterName) {
          this.filterInputText = params.filterName;
          this.dataSource.filter = this.filterInputText.trim().toLowerCase();

          if(this.dataSource.paginator) {
            this.dataSource.paginator.firstPage();
          }
        } else {
          this.filterInputText = "";
        }
      });
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

  expandShare(share: Share) {
    this.expandedElement = this.expandedElement == share ? null : share;
    if(this.expandedElement) {
      let tmp = JSON.parse(this.expandedElement.history);
      tmp.reverse();
      console.log(tmp);
      let low = [];
      let high = [];
      let open = [];
      let close = [];
      tmp.forEach(d => {
        low.push({name: d.date, value: d.low});
        high.push({name: d.date, value: d.high});
        open.push({name: d.date, value: d.open});
        close.push({name: d.date, value: d.close});
      });
      this.multi = [
        {
          "name": "High",
          "series": high
        },
        {
          "name": "Low",
          "series": low
        },
        {
          "name": "Open",
          "series": open
        },
        {
          "name": "Close",
          "series": close
        }
      ]
    }
  }
}

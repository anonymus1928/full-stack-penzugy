import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddEditTransactionComponent } from './add-edit-transaction.component';

describe('AddEditTransactionComponent', () => {
  let component: AddEditTransactionComponent;
  let fixture: ComponentFixture<AddEditTransactionComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AddEditTransactionComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AddEditTransactionComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

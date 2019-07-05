import { BehaviorSubject } from "rxjs/BehaviorSubject";
import { DataSource } from "@angular/cdk/collections";
import {
  MatSort,
  MatPaginator,
  MatChipInputEvent,
  MatDialog
} from "@angular/material";
import { Budget } from "../models/Budget/Budget";
import { WorksDatabase } from "../data-sources/works-database";
import { Observable } from "rxjs/Rx";

export class WorksDataSource extends DataSource<any> {
  _filterChange = new BehaviorSubject([]);
  get filter(): string[] {
    return this._filterChange.value;
  }
  set filter(filter: string[]) {
    this._filterChange.next(filter);
  }

  filteredData: Budget[] = [];
  renderedData: Budget[] = [];

  constructor(
    private _worksDatabase: WorksDatabase,
    private _paginator: MatPaginator,
    private _sort: MatSort
  ) {
    super();

    this._filterChange.subscribe(() => (this._paginator.pageIndex = 0));
  }

  connect(): Observable<Budget[]> {
    const displayDataChanges = [
      this._worksDatabase.dataChange,
      this._sort.sortChange,
      this._filterChange,
      this._paginator.page
    ];

    return Observable.merge(...displayDataChanges).map(() => {
      this.filteredData = this._worksDatabase.data
        .slice()
        .filter((item: any) => {
          // if (item.infoProveedor) return true;
          if (item != undefined) {
            if (item.notes != undefined) {
              let searchStr = item.notes.toLowerCase();

              var is = true;
              this.filter.forEach(element => {
                if (searchStr.indexOf(element.toLowerCase()) == -1) {
                  is = false;
                }
              });
              return is;
            }
          }
          return true;
        });

      const sortedData = this.sortData(this.filteredData.slice());

      const startIndex = this._paginator.pageIndex * this._paginator.pageSize;

      this.renderedData = sortedData.splice(
        startIndex,
        this._paginator.pageSize
      );

      return this.renderedData;
    });
  }

  disconnect() {}

  sortData(data: Budget[]): Budget[] {
    if (!this._sort.active || this._sort.direction == "") {
      return data;
    }

    return data.sort((a, b) => {
      let propertyA: number | string = "";
      let propertyB: number | string = "";

      switch (this._sort.active) {
        case "date":
          [propertyA, propertyB] = [
            a.due_date.toDateString(),
            b.due_date.toDateString()
          ];
          break;
      }

      let valueA = isNaN(+propertyA) ? propertyA : +propertyA;
      let valueB = isNaN(+propertyB) ? propertyB : +propertyB;

      return (
        (valueA > valueB ? -1 : 1) * (this._sort.direction == "asc" ? 1 : -1)
      );
    });
  }
}

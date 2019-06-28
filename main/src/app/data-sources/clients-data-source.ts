import { BehaviorSubject } from "rxjs/BehaviorSubject";
import { DataSource } from "@angular/cdk/collections";
import {
  MatSort,
  MatPaginator,
  MatChipInputEvent,
  MatDialog
} from "@angular/material";
import { Client } from "../models/Client/Client";
import { ClientsDatabase } from "../data-sources/clients-database";
import { Observable } from "rxjs/Rx";

export class ClientsDataSource extends DataSource<any> {
  _filterChange = new BehaviorSubject([]);
  get filter(): string[] {
    return this._filterChange.value;
  }
  set filter(filter: string[]) {
    this._filterChange.next(filter);
  }

  filteredData: Client[] = [];
  renderedData: Client[] = [];

  constructor(
    private _clientsDatabase: ClientsDatabase,
    private _paginator: MatPaginator,
    private _sort: MatSort
  ) {
    super();

    this._filterChange.subscribe(() => (this._paginator.pageIndex = 0));
  }

  connect(): Observable<Client[]> {
    const displayDataChanges = [
      this._clientsDatabase.dataChange,
      this._sort.sortChange,
      this._filterChange,
      this._paginator.page
    ];

    return Observable.merge(...displayDataChanges).map(() => {
      this.filteredData = this._clientsDatabase.data
        .slice()
        .filter((item: any) => {
          // if (item.infoProveedor) return true;
          if (item != undefined) {
            if (item.name != undefined) {
              let searchStr = (
                item.name +
                item.phone +
                item.address
              ).toLowerCase();

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

  sortData(data: Client[]): Client[] {
    if (!this._sort.active || this._sort.direction == "") {
      return data;
    }

    return data.sort((a, b) => {
      let propertyA: number | string = "";
      let propertyB: number | string = "";

      switch (this._sort.active) {
        case "name":
          [propertyA, propertyB] = [a.name, b.name];
          break;
      }

      let valueA = isNaN(+propertyA) ? propertyA : +propertyA;
      let valueB = isNaN(+propertyB) ? propertyB : +propertyB;

      return (
        (valueA < valueB ? -1 : 1) * (this._sort.direction == "asc" ? 1 : -1)
      );
    });
  }
}

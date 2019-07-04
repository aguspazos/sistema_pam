import { Component, OnInit } from "@angular/core";
import { Budget } from "../../models";
import { WorksService } from "../../services/works.service";

@Component({
  selector: "app-admin-budgets",
  templateUrl: "./admin-budgets.component.html",
  styleUrls: ["./admin-budgets.component.css"]
})
export class AdminBudgetsComponent implements OnInit {
  works: Budget[];

  constructor(private worksService: WorksService) {
    this.loadWorks();
    this.worksService.dataChange.subscribe(changed => {
      if (changed) {
        this.loadWorks();
      }
    });
  }

  ngOnInit() {}

  loadWorks() {
    this.works = this.worksService.activeWorksDatabase.data;
    this.works = this.sortWorks(this.works);
  }

  sortWorks(data: Budget[]): Budget[] {
    return data.sort((a, b) => {
      return a < b ? -1 : 1;
    });
  }
}

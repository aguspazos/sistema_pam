import { Component, OnInit } from "@angular/core";
import { Budget } from "../../models";
import { WorksService } from "../../services/works.service";

@Component({
  selector: "app-budget-history",
  templateUrl: "./budget-history.component.html",
  styleUrls: ["./budget-history.component.css"]
})
export class BudgetHistoryComponent implements OnInit {
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
    this.works = this.worksService.deliveredWorksDatabase.data;
  }
}

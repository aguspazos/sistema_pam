import { Component, OnInit } from "@angular/core";
import { Budget } from "../../models";
import { WorksService } from "../../services/works.service";

@Component({
  selector: "app-active-budget-list",
  templateUrl: "./active-budget-list.component.html",
  styleUrls: ["./active-budget-list.component.css"]
})
export class ActiveBudgetListComponent implements OnInit {
  works: Budget[];
  notes: string;

  constructor(private worksService: WorksService) {
    this.notes = "";
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
    this.notes = "";
  }

  sortWorks(data: Budget[]): Budget[] {
    return data.sort((a, b) => {
      return a < b ? -1 : 1;
    });
  }

  advance(work) {
    this.worksService.changeStatus(work, this.notes);
  }
}

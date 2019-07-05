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

  isOverdue(work) {
    var budget = work as Budget;
    var today = new Date();
    var dueDate = new Date(budget.due_date);
    if (dueDate > today) {
      return false;
    }
    return true;
  }
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
    this.works.forEach(w => {
      w.status_notes = "";
      if (w.work_bounds != undefined) {
        if (w.work_bounds.type != undefined) {
          if ("" + w.work_bounds.type == "1")
            w.work_bounds.string_type = "Intercalado";
          else if ("" + w.work_bounds.type == "2")
            w.work_bounds.string_type = "Cocido";
          else w.work_bounds.string_type = w.work_bounds.others;
        }
      }
      if (w.work_laminates != undefined) {
        if (w.work_laminates.type != undefined) {
          if ("" + w.work_laminates.type == "1")
            w.work_laminates.string_type = "Mate";
          else if ("" + w.work_laminates.type == "2")
            w.work_laminates.string_type = "Brillo";
          else if ("" + w.work_laminates.type == "3")
            w.work_laminates.string_type = "Soft Touch";
          else w.work_laminates.string_type = "-";
        }
      }
    });
    this.works = this.sortWorks(this.works);
  }

  sortWorks(data: Budget[]): Budget[] {
    return data.sort((a: Budget, b: Budget) => {
      return a.due_date < b.due_date ? -1 : 1;
    });
  }

  advance(work) {
    var note = work.status_notes;
    work.status_notes = "";
    this.worksService.changeStatus(work, note);
  }
}

import { Component, OnInit } from "@angular/core";
import { WorksService } from "../../services/works.service";
import { Budget } from "../../models";

@Component({
  selector: "app-shipments",
  templateUrl: "./shipments.component.html",
  styleUrls: ["./shipments.component.css"]
})
export class ShipmentsComponent implements OnInit {
  works: Budget[];
  notes = "";
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
    this.notes = "";
    this.works = this.worksService.finishedWorksDatabase.data;
  }

  advance(work) {
    this.worksService.changeStatus(work, this.notes);
  }
}

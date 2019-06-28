import { Component, OnInit } from "@angular/core";
import { ClientsService } from "../../services/clients.service";

@Component({
  selector: "app-client-layout",
  templateUrl: "./client-layout.component.html",
  styleUrls: ["./client-layout.component.css"]
})
export class ClientLayoutComponent implements OnInit {
  constructor(public clientsService: ClientsService) {}

  ngOnInit() {
    this.clientsService.showClient = false;
    this.clientsService.showList = true;
    this.clientsService.showCreate = false;
  }

  showList() {
    this.clientsService.showClient = false;
    this.clientsService.showList = true;
    this.clientsService.showCreate = false;
  }
}

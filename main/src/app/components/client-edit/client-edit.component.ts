import { Component, OnInit } from "@angular/core";
import { Client } from "../../models/Client/Client";
import { ClientsService } from "../../services/clients.service";
import { AlertService } from "../../services";

@Component({
  selector: "clients-edit",
  templateUrl: "./client-edit.component.html",
  styleUrls: ["./client-edit.component.css"]
})
export class ClientEditComponent implements OnInit {
  public client: Client;
  constructor(
    private alertService: AlertService,
    private clientsService: ClientsService
  ) {
    this.client = this.clientsService.clientToEdit;
  }

  validateClient() {
    if (
      this.client.name == undefined ||
      this.client.address == undefined ||
      this.client.phone == undefined ||
      this.client.mail == undefined
    )
      return false;
    return true;
  }
  saveClient() {
    if (this.validateClient()) {
      try {
        this.clientsService.createClient(this.client);
      } catch (e) {
        this.alertService.error("Ocurrió un error.", "OK");
      }
    } else {
      this.alertService.error("Debes completar todos los campos");
    }
  }

  ngOnInit() {}
}

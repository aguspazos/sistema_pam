import { Component, OnInit } from "@angular/core";
import { Client } from "../../models/Client/Client";
import { AlertService } from "../../services";
import { ClientsService } from "../../services/clients.service";
import { HttpErrorResponse } from "@angular/common/http";

@Component({
  selector: "clients-create",
  templateUrl: "./client-create.component.html",
  styleUrls: ["./client-create.component.css"]
})
export class ClientCreateComponent implements OnInit {
  public client: Client;
  constructor(
    private alertService: AlertService,
    private clientsService: ClientsService
  ) {
    this.client = new Client();
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

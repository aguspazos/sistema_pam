import { Injectable, Output, EventEmitter } from "@angular/core";
import { ClientsDatabase } from "../data-sources/clients-database";
import {
  HttpClient,
  HttpHeaders,
  HttpErrorResponse
} from "@angular/common/http";
import { _throw } from "rxjs/observable/throw";

import { AppConfig } from "../app.config";
import { BehaviorSubject } from "rxjs";
import { Client } from "../models/Client/Client";
import { catchError } from "rxjs/operators";
import { Observable } from "rxjs/Rx";
import { analyzeAndValidateNgModules } from "@angular/compiler";
import { AlertService } from "./alert.service";

@Injectable({
  providedIn: "root"
})
export class ClientsService {
  public showList: boolean;
  public showCreate: boolean;
  public showClient: boolean;

  clientsDatabase: ClientsDatabase;
  private clientsSubject: BehaviorSubject<Client[]> = new BehaviorSubject([]);

  @Output() dataChange: EventEmitter<boolean> = new EventEmitter();
  isEditing: boolean;
  clientToEdit: any;
  private clients: Client[];
  private config: AppConfig;

  constructor(
    private http: HttpClient,
    private alertService: AlertService,
    private myConfig: AppConfig
  ) {
    this.config = myConfig;
    this.clientsDatabase = new ClientsDatabase();
    this.http
      .post(
        this.config.apiUrl + "/clients/getAllArray",
        { token: myConfig.token },
        this.jwt()
      )
      .subscribe(response => {
        var res = response as any;
        var clients = res.clients;
        var clientList = new Array<Client>();
        clients.forEach(jsonClient => {
          var name = jsonClient.name;
          var address = jsonClient.address;
          var phone = jsonClient.phone;
          var id = jsonClient.id;
          var client = new Client();
          client.name = name;
          client.id = id;
          client.address = address;
          client.phone = phone;
          clientList.push(client);
        });
        this.clients = clientList;
        this.clientsSubject.next(this.clients);
        this.clientsDatabase.updateClient(this.clients);
        this.dataChange.emit(true);
      });
  }

  manageCreateClient = (data: any) => {
    var createdClient = data as Client;
    this.clientsDatabase.addClient(createdClient);
    this.addClientToLocalDb(createdClient);
    this.dataChange.emit(true);
    this.alertService.success("Cliente Creado.", "OK");
    this.showCreate = false;
    this.showList = true;
  };

  public createClient(client: Client) {
    this.http
      .post(
        this.config.apiUrl + "/clients/add",
        {
          token: this.config.token,
          name: client.name,
          address: client.address,
          mail: client.mail,
          phone: client.phone
        },
        this.jwt()
      )
      .subscribe(response => {
        var res = response as any;
        var status = res.status;
        if (status == "ok") {
          var id = res.id;
          client.id = id;
          this.manageCreateClient(client);
        } else {
          this.alertService.error("Error inesperado");
        }
      });
  }

  public deleteClientFromLocalDb(client: Client) {
    var clientArray = this.clientsSubject.getValue();
    clientArray = clientArray.filter(obj => obj.id !== client.id);
    this.clientsSubject.next(clientArray);
  }

  public deleteClient(client: Client) {
    /*   return this.http
      .delete<Client>(this.config.apiUrl + "/grupos/" + client.id, this.jwt())
      .pipe(catchError(this.handleError));*/
  }

  private jwt() {
    let token = localStorage.getItem("token");
    if (token) {
      let headers = new HttpHeaders({ Authorization: "Bearer " + token });
      return { headers };
    }
  }

  public addClientToLocalDb(client: Client) {
    var clientArray = this.clientsSubject.getValue();
    clientArray.push(client);
    this.clientsSubject.next(clientArray);
  }

  private handleError(error: HttpErrorResponse) {
    console.log("error");
    if (error.error instanceof ErrorEvent) {
      // A client-side or network error occurred. Handle it accordingly.
      console.error("An error occurred:", error.error.message);
    } else {
      // The backend returned an unsuccessful response code.
      // The response body may contain clues as to what went wrong,
      console.error(
        `Backend returned code ${error.status}, ` + `body was: ${error.error}`
      );
    }
    // return an observable with a user-facing error message
    return _throw(error);
  }
}

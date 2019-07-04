import { Component, OnInit, Input, ViewChild } from "@angular/core";
import { MatPaginator, MatSort, MatDialog } from "@angular/material";
import { Subscription } from "rxjs";
import { AlertService } from "../../services";
import { HttpErrorResponse } from "@angular/common/http";
import { Client } from "../../models/Client/Client";
import { ClientsService } from "../../services/clients.service";
import { AuthenticationService } from "../../services/authentication.service";
import { ClientsDatabase } from "../../data-sources/clients-database";
import { ClientsDataSource } from "../../data-sources/clients-data-source";

@Component({
  selector: "clients-list",
  templateUrl: "./client-list.component.html",
  styleUrls: ["./client-list.component.css"]
})
export class ClientListComponent implements OnInit {
  @Input() client;
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @ViewChild(MatSort) sort: MatSort;
  clientsSubscription: Subscription;
  dataSource: ClientsDataSource | null;
  clientsDatabase: ClientsDatabase;
  clients: Client[];
  clientsLength = 0;

  // Propiedades de ayuda
  displayedColumns = ["name", "phone", "address", "delete"];
  showCreateBusinessGroups = true;
  canEdit = false;
  constructor(
    public clientsService: ClientsService,
    private alertService: AlertService,
    public dialog: MatDialog,
    private authenticationService: AuthenticationService
  ) {
    this.loadClients();
    this.clientsDatabase = clientsService.clientsDatabase;
  }

  loadClients() {
    this.clients = this.clientsService.clientsDatabase.data;
    this.clientsLength = this.clients.length;
  }

  ngOnInit() {
    this.loadClients();
    this.clientsService.dataChange.subscribe(changed => {
      if (changed) {
        this.loadClients();
      }
    });
    this.initializeVariables();
  }

  initializeVariables() {
    this.dataSource = new ClientsDataSource(
      this.clientsDatabase,
      this.paginator,
      this.sort
    );

    this.paginator._intl.itemsPerPageLabel = "Registros por página";
    this.paginator._intl.getRangeLabel = (page, size, length) =>
      `Pág. ${page + 1} de ${Math.ceil(length / size)}`;
  }

  openDeleteDialog(groupToDelete): void {
    /*  const dialogRef = this.dialog.open(ConfirmDeleteGroupDialogComponent, {
      width: "450px",
      data: { group: groupToDelete }
    });
    dialogRef.afterClosed().subscribe(result => {
      //	this.manageDeleteGroup(groupToDelete);
      //this.router.navigate(['/listas-venta']);
    });*/
  }

  manageDeleteGroup(data: any): any {
    this.alertService.success("Grupo eliminado", "OK");
    var deletedClient = data.data as Client;
    this.clientsService.clientsDatabase.deleteClient(deletedClient);
    this.clientsService.deleteClientFromLocalDb(deletedClient);
    this.clientsService.dataChange.emit(true);
  }

  deleteClient(client) {
    /*try {
      this.clientsService.deleteClient(client).subscribe(
        data => {
          this.manageDeleteGroup(data);
        },
        error => {
          var httpError = error as HttpErrorResponse;
          if (httpError.status == 401) {
            this.alertService.error("Debes iniciar sesión.", "OK");
            this.authenticationService.logout();
          } else {
            this.alertService.error(
              "Ocurrió un error: " + httpError.error.message,
              "OK"
            );
          }
        }
      );
    } catch (e) {
      this.alertService.error("Ocurrió un error.", "OK");
    }*/
  }
  editClient(client) {
    this.clientsService.showClient = true;
    this.clientsService.showList = false;
    this.clientsService.showCreate = false;
    this.clientsService.clientToEdit = client;
    this.clientsService.isEditing = true;
  }
  watchClient(client) {
    this.clientsService.showClient = true;
    this.clientsService.showList = false;
    this.clientsService.showCreate = false;
    this.clientsService.clientToEdit = client;
    this.clientsService.isEditing = false;
    /*this.groupService.showGroupEdit = true;
		
		this.groupService.fromWatch = true;
		this.groupService.dataChange.emit(true);*/
  }
  showCreate() {
    this.clientsService.showClient = false;
    this.clientsService.showList = false;
    this.clientsService.showCreate = true;
  }
}

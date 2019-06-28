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
  displayedColumns = ["name", "phone", "delete"];
  showCreateBusinessGroups = true;
  canEdit = false;
  constructor(
    public clientsService: ClientsService,
    private alertService: AlertService,
    public dialog: MatDialog,
    private authenticationService: AuthenticationService
  ) {
    this.loadGroups();
    this.clientsDatabase = clientsService.clientsDatabase;
    if (
      this.authenticationService.can("crearGruposDeEmpresa") ||
      this.authenticationService.can("administradorEmpresa")
    ) {
      this.showCreateBusinessGroups = true;
    } else {
      this.showCreateBusinessGroups = false;
    }
  }

  loadGroups() {
    this.groups = this.groupService.groupsDatabase.data;
    this.groupsLength = this.groups.length;
  }

  ngOnInit() {
    this.loadGroups();
    this.groupService.dataChange.subscribe(changed => {
      if (changed) {
        this.loadGroups();
      }
    });
    this.initializeVariables();
  }

  initializeVariables() {
    if (
      this.authenticationService.can("crearGruposDeEmpresa") ||
      this.authenticationService.can("administradorEmpresa")
    ) {
      this.canEdit = true;
    } else this.canEdit = false;
    this.dataSource = new GroupsDataSource(
      this.groupsDatabase,
      this.paginator,
      this.sort
    );

    this.paginator._intl.itemsPerPageLabel = "Registros por página";
    this.paginator._intl.getRangeLabel = (page, size, length) =>
      `Pág. ${page + 1} de ${Math.ceil(length / size)}`;
  }

  openDeleteDialog(groupToDelete): void {
    const dialogRef = this.dialog.open(ConfirmDeleteGroupDialogComponent, {
      width: "450px",
      data: { group: groupToDelete }
    });
    dialogRef.afterClosed().subscribe(result => {
      //	this.manageDeleteGroup(groupToDelete);
      //this.router.navigate(['/listas-venta']);
    });
  }

  manageDeleteGroup(data: any): any {
    this.alertService.success("Grupo eliminado", "OK");
    var deletedGroup = data.data as Grupo;
    this.groupService.groupsDatabase.deleteGroup(deletedGroup);
    this.groupService.deleteGroupFromLocalDb(deletedGroup);
    this.groupService.dataChange.emit(true);
  }

  deleteGroup(group) {
    try {
      this.groupService.deleteGroup(group).subscribe(
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
    }
  }
  editGroup(group) {
    this.groupService.showGroup = true;
    this.groupService.showList = false;
    this.groupService.showCreate = false;
    this.groupService.groupToEdit = group;
    this.groupService.isEditing = true;
  }
  watchGroup(group) {
    this.groupService.showGroup = true;
    this.groupService.showList = false;
    this.groupService.showCreate = false;
    this.groupService.groupToEdit = group;
    this.groupService.isEditing = false;
    /*this.groupService.showGroupEdit = true;
		
		this.groupService.fromWatch = true;
		this.groupService.dataChange.emit(true);*/
  }
  showCreate() {
    this.groupService.showGroup = false;
    this.groupService.showList = false;
    this.groupService.showCreate = true;
  }
}

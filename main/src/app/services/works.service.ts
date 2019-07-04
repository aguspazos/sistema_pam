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
import { WorksDatabase } from "../data-sources/works-database";
import { Budget, CutState } from "../models";

@Injectable({
  providedIn: "root"
})
export class WorksService {
  activeWorksDatabase: WorksDatabase;
  finishedWorksDatabase: WorksDatabase;
  deliveredWorksDatabase: WorksDatabase;
  private activeSubject: BehaviorSubject<Budget[]> = new BehaviorSubject([]);
  private finishedSubject: BehaviorSubject<Budget[]> = new BehaviorSubject([]);
  private deliveredSubject: BehaviorSubject<Budget[]> = new BehaviorSubject([]);

  @Output() dataChange: EventEmitter<boolean> = new EventEmitter();
  isEditing: boolean;
  budgetToEdit: any;
  private config: AppConfig;

  jsonToWork(jsonWork) {
    var work = new Budget();
    work.id = jsonWork.id;
    work.print_type_id = jsonWork.print_type_id;
    work.paper_size = jsonWork.paper_size;
    work.prints_amount = jsonWork.prints_amount;
    work.image_url = jsonWork.image_url;
    work.notes = jsonWork.notes;
    work.current_status_type_id = jsonWork.current_status_type_id;
    work.current_work_status_id = jsonWork.current_work_status_id;
    work.client = jsonWork.client;
    work.due_date = jsonWork.due_date;
    work.next_status_name = jsonWork.next_status_name;
    if (jsonWork.work_laminates == "noData") {
      work.work_laminates = undefined;
    } else work.work_laminates = jsonWork.work_laminates;

    work.work_prints = new CutState();
    if (jsonWork.work_rumblings == "noData") {
      work.work_rumblings = undefined;
    } else work.work_rumblings = jsonWork.work_rumblings;

    if (jsonWork.work_bounds == "noData") {
      work.work_bounds = undefined;
    } else work.work_bounds = jsonWork.work_bounds;

    if (jsonWork.work_uvs == "noData") {
      work.work_uvs = undefined;
    } else work.work_uvs = jsonWork.work_uvs;
    return work;
  }

  constructor(
    private http: HttpClient,
    private alertService: AlertService,
    private myConfig: AppConfig
  ) {
    this.config = myConfig;
    this.activeWorksDatabase = new WorksDatabase();
    this.finishedWorksDatabase = new WorksDatabase();
    this.deliveredWorksDatabase = new WorksDatabase();
    this.http
      .post(
        this.config.apiUrl + "/works/getAllNotFinished",
        { token: myConfig.token },
        this.jwt()
      )
      .subscribe(response => {
        var res = response as any;
        var status = res.status;
        if (status == "ok") {
          var notFinished = res.works;
          if (notFinished != undefined) {
            var notFinishedList = new Array<Budget>();
            notFinished.forEach(jsonWork => {
              var work = this.jsonToWork(jsonWork);
              notFinishedList.push(work);
            });
            this.activeSubject.next(notFinishedList);
            this.activeWorksDatabase.updateBudget(notFinishedList);
            this.dataChange.emit(true);
          }
        }
      });

    this.http
      .post(
        this.config.apiUrl + "/works/getAllSent",
        { token: myConfig.token },
        this.jwt()
      )
      .subscribe(response => {
        var res = response as any;
        var status = res.status;
        if (status == "ok") {
          var sent = res.trabajos;
          if (sent != undefined) {
            var sentList = new Array<Budget>();
            sent.forEach(jsonWork => {
              var work = this.jsonToWork(jsonWork);
              sentList.push(work);
            });
            this.deliveredSubject.next(sentList);
            this.deliveredWorksDatabase.updateBudget(sentList);
            this.dataChange.emit(true);
          }
        }
      });

    this.http
      .post(
        this.config.apiUrl + "/works/getAllToSend",
        { token: myConfig.token },
        this.jwt()
      )
      .subscribe(response => {
        var res = response as any;
        var status = res.status;
        if (status == "ok") {
          var toSend = res.trabajos;
          if (toSend != undefined) {
            var toSendList = new Array<Budget>();
            toSend.forEach(jsonWork => {
              var work = this.jsonToWork(jsonWork);
              toSendList.push(work);
            });
            this.finishedSubject.next(toSendList);
            this.finishedWorksDatabase.updateBudget(toSendList);
            this.dataChange.emit(true);
          }
        }
      });
  }

  manageCreateWork = (data: any) => {
    var createdWork = data as Budget;
    createdWork.work_prints = new CutState();
    createdWork.next_status_name = "Para Imprimir";
    this.activeWorksDatabase.addBudget(createdWork);
    this.addWorkToActive(createdWork);
    this.dataChange.emit(true);
    this.alertService.success("Trabajo Creado.", "OK");
  };
  /*
{

  
   "work_uvs":{"id":"1"},
   "work_bounds":{
   	"type":"1",
   	"others_text":""
   },
   "work_delivers":{
   	"client_id":"{{client_id}}",
	"deliver_date":"{{due_date}}"
   }
}


*/
  public jsonFromWork(work: Budget) {
    return {
      print_type_id: work.print_type_id,
      paper_size: work.paper_size,
      paper_type_id: work.paper_type_id,
      prints_amount: work.prints_amount,
      image_url: work.image_url,
      notes: work.notes,
      due_date: work.due_date,
      work_prints: { id: "1" },
      work_laminates: {
        printing: work.work_laminates.printing,
        type: work.work_laminates.type
      },
      work_rumblings: {
        shape: work.work_rumblings.shape,
        amount: work.work_rumblings.amount,
        detail: work.work_rumblings.detail
      },
      work_uvs: {
        id: "1"
      },
      work_bounds: {
        type: work.work_bounds.type,
        others_text: work.work_bounds.others
      },
      work_delivers: {
        client_id: work.work_delivers.client_id,
        deliver_date: work.work_delivers.deliver_date
      },
      token: this.config.token
    };
  }

  public changeStatus(work: Budget, notes: string) {
    var data = {
      token: this.config.token,
      work_id: work.id,
      notes: notes
    };

    this.http
      .post(this.config.apiUrl + "/works/nextStatus", data, this.jwt())
      .subscribe(response => {
        var res = response as any;
        var status = res.status;
        if (status == "ok") {
          var next_status_name = res.next_status_name;
          work.next_status_name = next_status_name;
          if (work.next_status_name == "Para Entregar") {
            this.removeWorkFromActive(work);
            this.alertService.success("Trabajo terminado", "OK");
          } else if (work.next_status_name == "Entregado") {
            this.removeWorkFromFinished(work);
            this.alertService.success("Trabajo Entregado", "OK");
          } else {
            this.deleteActiveFromLocalDb(work);
            this.addWorkToActive(work);
            this.dataChange.emit(true);
            this.alertService.success("Estado cambiado", "OK");
          }
        } else {
          this.alertService.error("Error inesperado");
        }
      });
  }

  public createWork(work: Budget) {
    work.token = this.config.token;

    this.http
      .post(this.config.apiUrl + "/works/add", work, this.jwt())
      .subscribe(response => {
        var res = response as any;
        var status = res.status;
        if (status == "ok") {
          var id = res.id;
          work.id = id;
          this.manageCreateWork(work);
        } else {
          this.alertService.error("Error inesperado");
        }
      });
  }

  public removeWorkFromActive(work: Budget) {
    var workArray = this.activeSubject.getValue();
    workArray = workArray.filter(obj => obj.id !== work.id);
    this.activeSubject.next(workArray);
    this.activeWorksDatabase.deleteBudget(work);
    this.addWorkToFinished(work);
    this.dataChange.emit(true);
  }

  public removeWorkFromFinished(work: Budget) {
    var workArray = this.finishedSubject.getValue();
    workArray = workArray.filter(obj => obj.id !== work.id);
    this.finishedSubject.next(workArray);
    this.finishedWorksDatabase.deleteBudget(work);
    this.addWorkToDelivered(work);
    this.dataChange.emit(true);
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

  public addWorkToActive(work: Budget) {
    var workArray = this.activeSubject.getValue();
    workArray.push(work);
    this.activeSubject.next(workArray);
  }

  public addWorkToFinished(work: Budget) {
    var workArray = this.finishedSubject.getValue();
    workArray.push(work);
    this.finishedSubject.next(workArray);
  }

  public addWorkToDelivered(work: Budget) {
    var workArray = this.deliveredSubject.getValue();
    workArray.push(work);
    this.deliveredSubject.next(workArray);
  }

  public deleteActiveFromLocalDb(work: Budget) {
    var workArray = this.activeSubject.getValue();
    workArray = workArray.filter(obj => obj.id !== work.id);
    this.activeSubject.next(workArray);
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

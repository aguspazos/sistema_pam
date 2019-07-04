import { Component, OnInit } from "@angular/core";
import {
  FormGroup,
  FormBuilder,
  FormControl,
  Validators
} from "@angular/forms";
import {
  Budget,
  RumblingState,
  UvState,
  BoundsState,
  Delivery
} from "../../models";
import { LaminatedState } from "../../models/LaminatedState/LaminatedState";
import { Client } from "../../models/Client/Client";
import { ClientsService } from "../../services/clients.service";
import { AlertService } from "../../services";
import { WorksService } from "../../services/works.service";

@Component({
  selector: "app-create-budget",
  templateUrl: "./create-budget.component.html",
  styleUrls: ["./create-budget.component.scss"]
})
export class CreateBudgetComponent implements OnInit {
  options: FormGroup;
  budget: Budget;
  lamination: LaminatedState;
  rumbling: RumblingState;
  uv: UvState;
  delivery: Delivery;
  bound: BoundsState;
  printTypeGroup;
  typeOptions = ["Digital", "Offset"];
  laminationOptions = ["Mate", "Brillo", "Soft Touch"];
  boundOptions = ["Intercalado", "Cocido", "Otros"];
  allClients: Client[];

  hasLamination = false;
  hasDieCutting = false;
  hasUV = false;
  hasBinding = false;
  hide = true;
  fecha: Date;

  constructor(
    private _formBuilder: FormBuilder,
    private clientsService: ClientsService,
    private worksService: WorksService,
    private alertService: AlertService
  ) {
    this.budget = new Budget();
    this.lamination = new LaminatedState();
    this.rumbling = new RumblingState();
    this.uv = new UvState();
    this.bound = new BoundsState();

    this.allClients = this.clientsService.clientsDatabase.data;
    this.clientsService.dataChange.subscribe(changed => {
      if (changed) {
        this.allClients = this.clientsService.clientsDatabase.data;
      }
    });
    this.worksService.dataChange.subscribe(changed => {
      if (changed) {
        console.log(JSON.stringify(this.worksService.activeWorksDatabase.data));
      }
    });
    this.options = _formBuilder.group({
      hideRequired: false,
      floatLabel: "auto"
    });
  }

  myClient;

  selectedClientChange(e) {
    var option = e.value;
  }

  laminatedSelectionChange(event) {
    if (event.value == "false") this.hasLamination = false;
    else this.hasLamination = true;
    if (this.hasLamination) this.budget.work_laminates = this.lamination;
    else this.budget.work_laminates = undefined;
  }

  dieCuttingSelectionChange(event) {
    if (event.value == "false") this.hasDieCutting = false;
    else this.hasDieCutting = true;
    if (this.hasDieCutting) this.budget.work_rumblings = this.rumbling;
    else this.budget.work_rumblings = undefined;
  }

  uvSelectionChange(event) {
    if (event.value == "false") this.hasUV = false;
    else this.hasUV = true;
    if (this.hasUV) this.budget.work_uvs = this.uv;
    else this.budget.work_uvs = undefined;
  }

  bindingSelectionChange(event) {
    if (event.value == "false") this.hasBinding = false;
    else this.hasBinding = true;
    if (this.hasBinding) this.budget.work_bounds = this.bound;
    else this.budget.work_bounds = undefined;
  }

  printTypeChange(e) {
    var option = e.value;
    if (option == "Digital") {
      //ver si cortarlo aca
      this.budget.print_type_id = 1;
    } else {
      this.budget.print_type_id = 2;
    }
  }

  laminationOptionChange(e) {
    var option = e.value;
    if (option == "Mate") {
      //ver si cortarlo aca
      this.lamination.type = 1;
    } else if (option == "Brillo") {
      this.lamination.type = 2;
    } else {
      this.lamination.type = 3;
    }
  }

  bindingOptionChange(e) {
    var option = e.value;
    if (option == "Intercalado") {
      //ver si cortarlo aca
      this.bound.type = 1;
    } else if (option == "Cocido") {
      this.bound.type = 2;
    } else {
      this.bound.type = 3;
    }
  }

  getErrors() {
    if (this.budget.print_type_id != 1 && this.budget.print_type_id != 2) {
      return "Debes elegir un tipo de impresión";
    }
    if (this.hasLamination) {
      if (this.lamination.type == 0) {
        return "Debes elegir un tipo de laminado";
      }
    }
    if (this.hasBinding) {
      if (this.bound.type == 0) {
        return "Debes elegir un tipo de encuadernación";
      }
    }
    return "ok";
  }

  ngOnInit() {}
  // For form validator
  email = new FormControl("", [Validators.required, Validators.email]);

  // Sufix and prefix

  public onDate(event): void {}

  saveBudget() {
    this.delivery = new Delivery();
    this.delivery.client_id = this.myClient.id;
    this.delivery.deliver_date = this.fecha.toDateString();
    this.budget.due_date = this.fecha;
    this.budget.client = this.myClient;
    this.budget.work_delivers = this.delivery;
    var errors = this.getErrors();
    if (errors == "ok") {
      try {
        this.worksService.createWork(this.budget);
      } catch (e) {
        this.alertService.error("Ocurrió un error.", "OK");
      }
    } else {
      this.alertService.error(errors);
    }
  }

  getErrorMessage() {
    return this.email.hasError("required")
      ? "You must enter a value"
      : this.email.hasError("email")
      ? "Not a valid email"
      : "";
  }
}

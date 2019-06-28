import { Component, OnInit } from "@angular/core";
import {
  FormGroup,
  FormBuilder,
  FormControl,
  Validators
} from "@angular/forms";
import { Budget, RumblingState, UvState, BoundsState } from "../../models";
import { LaminatedState } from "../../models/LaminatedState/LaminatedState";

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
  bound: BoundsState;
  printTypeGroup;
  typeOptions = ["Digital", "Offset"];
  laminationOptions = ["Mate", "Brillo", "Soft Touch"];
  boundOptions = ["Intercalado", "Cocido", "Otros"];

  hasLamination = false;
  hasDieCutting = false;
  hasUV = false;
  hasBinding = false;
  hide = true;
  fecha;

  constructor(private _formBuilder: FormBuilder) {
    this.budget = new Budget();
    this.lamination = new LaminatedState();
    this.rumbling = new RumblingState();
    this.uv = new UvState();
    this.bound = new BoundsState();

    this.options = _formBuilder.group({
      hideRequired: false,
      floatLabel: "auto"
    });
  }

  laminatedSelectionChange() {
    this.hasLamination = !this.hasLamination;
    if (this.hasLamination) this.budget.work_laminates = this.lamination;
    else this.budget.work_laminates = new LaminatedState();
  }

  dieCuttingSelectionChange() {
    this.hasDieCutting = !this.hasDieCutting;
    if (this.hasDieCutting) this.budget.work_rumblings = this.rumbling;
    else this.budget.work_rumblings = new RumblingState();
  }

  uvSelectionChange() {
    this.hasUV = !this.hasUV;
    if (this.hasUV) this.budget.work_uvs = this.uv;
    else this.budget.work_uvs = new UvState();
  }

  bindingSelectionChange() {
    this.hasBinding = !this.hasBinding;
    if (this.hasBinding) this.budget.work_bounds = this.bound;
    else this.budget.work_bounds = new BoundsState();
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

  public onDate(event): void {
    alert(event);
  }

  saveBudget() {
    console.log(JSON.stringify(this.budget));
  }
  getErrorMessage() {
    return this.email.hasError("required")
      ? "You must enter a value"
      : this.email.hasError("email")
      ? "Not a valid email"
      : "";
  }
}

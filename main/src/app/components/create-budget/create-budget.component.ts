import { Component, OnInit } from "@angular/core";
import {
  FormGroup,
  FormBuilder,
  FormControl,
  Validators
} from "@angular/forms";

@Component({
  selector: "app-create-budget",
  templateUrl: "./create-budget.component.html",
  styleUrls: ["./create-budget.component.scss"]
})
export class CreateBudgetComponent implements OnInit {
  options: FormGroup;
  firstFormGroup: FormGroup;
  secondFormGroup: FormGroup;
  thirdFormGroup: FormGroup;
  dieCuttingFormGroup: FormGroup;
  laminationFormGroup: FormGroup;
  uvFormGroup: FormGroup;
  bindingFormGroup: FormGroup;

  hasLamination = false;
  hasDieCutting = false;
  hasUV = false;
  hasBinding = false;

  constructor(private _formBuilder: FormBuilder) {
    this.options = _formBuilder.group({
      hideRequired: false,
      floatLabel: "auto"
    });
  }
  laminatedSelectionChange() {
    this.hasLamination = !this.hasLamination;
  }

  dieCuttingSelectionChange() {
    this.hasDieCutting = !this.hasDieCutting;
  }

  uvSelectionChange() {
    this.hasUV = !this.hasUV;
  }

  bindingSelectionChange() {
    this.hasBinding = !this.hasBinding;
  }

  ngOnInit() {
    this.firstFormGroup = this._formBuilder.group({
      firstCtrl: ["", Validators.required]
    });
    this.secondFormGroup = this._formBuilder.group({
      secondCtrl: ["", Validators.required]
    });
    this.thirdFormGroup = this._formBuilder.group({
      thirdCtrl: ["", Validators.required]
    });
    this.dieCuttingFormGroup = this._formBuilder.group({
      dieCuttingCtrl: ["", Validators.required]
    });
    this.laminationFormGroup = this._formBuilder.group({
      laminationCtrl: ["", Validators.required]
    });
    this.uvFormGroup = this._formBuilder.group({
      uvCtrl: ["", Validators.required]
    });
    this.bindingFormGroup = this._formBuilder.group({
      bindingCtrl: ["", Validators.required]
    });
  }
  // For form validator
  email = new FormControl("", [Validators.required, Validators.email]);

  // Sufix and prefix
  hide = true;

  fecha;
  public onDate(event): void {
    alert(event);
  }

  saveBudget() {
    alert(this.fecha);
  }
  getErrorMessage() {
    return this.email.hasError("required")
      ? "You must enter a value"
      : this.email.hasError("email")
      ? "Not a valid email"
      : "";
  }
}

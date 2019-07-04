import { BehaviorSubject } from "rxjs/BehaviorSubject";
import { Budget } from "../models/Budget/Budget";

export class WorksDatabase {
  dataChange: BehaviorSubject<Budget[]> = new BehaviorSubject<Budget[]>([]);
  get data(): Budget[] {
    return this.dataChange.value;
  }

  addBudget(element) {
    const copiedData = this.data.slice();
    copiedData.push(element);
    this.dataChange.next(copiedData);
  }

  deleteBudget(element) {
    var copiedData = this.data.slice();
    copiedData = copiedData.filter(obj => obj !== element);
    this.dataChange.next(copiedData);
  }

  updateBudget(budgets) {
    this.dataChange.next(budgets);
  }
}

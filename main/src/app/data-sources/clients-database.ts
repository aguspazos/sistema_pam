import { BehaviorSubject } from "rxjs/BehaviorSubject";
import { Client } from "../models/Client/Client";

export class ClientsDatabase {
  dataChange: BehaviorSubject<Client[]> = new BehaviorSubject<Client[]>([]);
  get data(): Client[] {
    return this.dataChange.value;
  }

  addClient(element) {
    const copiedData = this.data.slice();
    copiedData.push(element);
    this.dataChange.next(copiedData);
  }

  deleteClient(element) {
    var copiedData = this.data.slice();
    copiedData = copiedData.filter(obj => obj !== element);
    this.dataChange.next(copiedData);
  }

  updateClient(groups) {
    this.dataChange.next(groups);
  }
}

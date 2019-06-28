import { Injectable } from "@angular/core";

@Injectable({
  providedIn: "root"
})
export class ClientsService {
  public showList: boolean;
  public showCreate: boolean;
  public showClient: boolean;
  constructor() {}
}

import { Injectable } from "@angular/core";
import { Http, Response } from "@angular/http";
import { AppConfig } from "../app.config";
import { map } from "rxjs/operators";

@Injectable({
  providedIn: "root"
})
export class UsersService {
  constructor(private http: Http, private config: AppConfig) {}

  login(formUsuario) {
    return this.http
      .post(this.config.apiUrl + "/administrators/login", formUsuario)
      .pipe(
        map(
          (response: Response) => {
            let data = response.json().data;
            localStorage.setItem("token", data.token);
            localStorage.setItem("role", "providerAdmin");
            localStorage.setItem("roles", JSON.stringify(data.roles));
            localStorage.setItem("user", JSON.stringify(data.user));
            if (data.business != undefined) {
              localStorage.setItem("business", JSON.stringify(data.business));
            }
            localStorage.setItem("businesses", JSON.stringify(data.businesses));
          },
          err => {
            return false;
          }
        )
      );
  }
}

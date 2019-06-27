import { Component } from "@angular/core";
import { PerfectScrollbarConfigInterface } from "ngx-perfect-scrollbar";
@Component({
  selector: "app-header",
  templateUrl: "./header.component.html",
  styleUrls: []
})
export class AppHeaderComponent {
  public config: PerfectScrollbarConfigInterface = {};
  // This is for Notifications
  notifications: Object[] = [
    {
      round: "round-danger",
      icon: "ti-link",
      title: "Pronto para entregar",
      subject: 'El trabajo "Impresion 1" está pronto para entregar',
      time: "9:30 AM"
    },
    {
      round: "round-success",
      icon: "ti-calendar",
      title: "Entregado",
      subject: 'El trabajo "Impresion 2" ha sido entregado',
      time: "9:10 AM"
    },
    {
      round: "round-info",
      icon: "ti-settings",
      title: "Nuevo trabajo",
      subject: 'El vendedor "Federico" ha ingresado un nuevo trabajo',
      time: "9:08 AM"
    }
  ];

  // This is for Mymessages
}

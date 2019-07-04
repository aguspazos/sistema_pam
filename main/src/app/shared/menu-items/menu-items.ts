import { Injectable } from "@angular/core";

export interface BadgeItem {
  type: string;
  value: string;
}
export interface Saperator {
  name: string;
  type?: string;
}
export interface SubChildren {
  state: string;
  name: string;
  type?: string;
}
export interface ChildrenItems {
  state: string;
  name: string;
  type?: string;
  child?: SubChildren[];
}

export interface Menu {
  state: string;
  name: string;
  type: string;
  icon: string;
  badge?: BadgeItem[];
  saperator?: Saperator[];
  children?: ChildrenItems[];
}

const MENUITEMS = [
  {
    state: "",
    name: "Administración",
    type: "saperator",
    icon: "av_timer"
  },
  {
    state: "presupuestos",
    name: "Trabajos",
    type: "sub",
    icon: "av_timer",
    children: [
      { state: "crear", name: "Crear Orden", type: "link" },
      {
        state: "listado",
        name: "Trabajos Activos",
        type: "link"
      },
      { state: "envios", name: "Envios", type: "link" },
      { state: "historial", name: "Historial", type: "link" }
    ]
  },
  {
    state: "usuarios",
    name: "Personal",
    type: "sub",
    icon: "av_timer",
    children: [{ state: "listado", name: "Usuarios", type: "link" }]
  },
  {
    state: "contactos",
    name: "Contactos",
    type: "sub",
    icon: "av_timer",
    children: [{ state: "clientes", name: "Clientes", type: "link" }]
  },

  {
    state: "",
    name: "Planta",
    type: "saperator",
    icon: "av_timer"
  },
  {
    state: "trabajos-activos",
    name: "Trabajos Activos",
    type: "link",
    icon: "widgets"
  }
];

@Injectable()
export class MenuItems {
  getMenuitem(): Menu[] {
    return MENUITEMS;
  }
}

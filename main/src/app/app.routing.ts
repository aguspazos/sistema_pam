import { Routes } from "@angular/router";

import { FullComponent } from "./layouts/full/full.component";
import { AppBlankComponent } from "./layouts/blank/blank.component";
import { CreateBudgetComponent } from "./components/create-budget/create-budget.component";
import { ActiveBudgetListComponent } from "./components/active-budget-list/active-budget-list.component";
import { AdminBudgetsComponent } from "./components/admin-budgets/admin-budgets.component";
import { ShipmentsComponent } from "./components/shipments/shipments.component";
import { BudgetHistoryComponent } from "./components/budget-history/budget-history.component";
import { UsersComponent } from "./components/users/users.component";
import { SettingsComponent } from "./components/settings/settings.component";
import { MyProfileComponent } from "./components/my-profile/my-profile.component";
import { LoginComponent } from "./components/login/login.component";
import { ClientListComponent } from "./components/client-list/client-list.component";
import { ProviderListComponent } from "./components/provider-list/provider-list.component";

export const AppRoutes: Routes = [
  {
    path: "",
    component: FullComponent,
    children: [
      {
        path: "presupuestos/crear",
        component: CreateBudgetComponent
      },
      {
        path: "presupuestos/listado",
        component: AdminBudgetsComponent
      },
      {
        path: "presupuestos/envios",
        component: ShipmentsComponent
      },
      {
        path: "presupuestos/historial",
        component: BudgetHistoryComponent
      },
      {
        path: "usuarios/listado",
        component: UsersComponent
      },
      {
        path: "contactos/clientes",
        component: ClientListComponent
      },
      {
        path: "contactos/proveedores",
        component: ProviderListComponent
      },

      {
        path: "trabajos-activos",
        component: ActiveBudgetListComponent
      },
      {
        path: "ajustes",
        component: SettingsComponent
      },
      {
        path: "perfil",
        component: MyProfileComponent
      },
      {
        path: "",
        redirectTo: "/dashboards/dashboard1",
        pathMatch: "full"
      },
      {
        path: "dashboards",
        loadChildren: "./dashboards/dashboards.module#DashboardsModule"
      },
      {
        path: "material",
        loadChildren:
          "./material-component/material.module#MaterialComponentsModule"
      },
      {
        path: "apps",
        loadChildren: "./apps/apps.module#AppsModule"
      },
      {
        path: "forms",
        loadChildren: "./forms/forms.module#FormModule"
      },
      {
        path: "tables",
        loadChildren: "./tables/tables.module#TablesModule"
      },
      {
        path: "datatables",
        loadChildren: "./datatables/datatables.module#DataTablesModule"
      },
      {
        path: "pages",
        loadChildren: "./pages/pages.module#PagesModule"
      },
      {
        path: "widgets",
        loadChildren: "./widgets/widgets.module#WidgetsModule"
      },
      {
        path: "charts",
        loadChildren: "./charts/chartslib.module#ChartslibModule"
      },
      {
        path: "multi",
        loadChildren: "./multi-dropdown/multi-dd.module#MultiModule"
      }
    ]
  },
  {
    path: "",
    component: AppBlankComponent,
    children: [
      {
        path: "login",
        component: LoginComponent
      }
    ]
  },
  {
    path: "**",
    redirectTo: "authentication/404"
  }
];

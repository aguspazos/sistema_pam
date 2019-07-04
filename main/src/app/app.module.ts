import * as $ from "jquery";
import { BrowserModule } from "@angular/platform-browser";
import { NgModule } from "@angular/core";
import { RouterModule } from "@angular/router";
import { FormsModule, ReactiveFormsModule } from "@angular/forms";
import { HttpClientModule, HttpClient } from "@angular/common/http";
import { AppRoutes } from "./app.routing";
import { AppComponent } from "./app.component";

import { FlexLayoutModule } from "@angular/flex-layout";
import { FullComponent } from "./layouts/full/full.component";
import { AppBlankComponent } from "./layouts/blank/blank.component";
import { AppHeaderComponent } from "./layouts/full/header/header.component";
import { AppSidebarComponent } from "./layouts/full/sidebar/sidebar.component";
import { BrowserAnimationsModule } from "@angular/platform-browser/animations";
import { DemoMaterialModule } from "./demo-material-module";
import { NgMultiSelectDropDownModule } from "ng-multiselect-dropdown";

import { PerfectScrollbarModule } from "ngx-perfect-scrollbar";
import { PERFECT_SCROLLBAR_CONFIG } from "ngx-perfect-scrollbar";
import { PerfectScrollbarConfigInterface } from "ngx-perfect-scrollbar";
import { SharedModule } from "./shared/shared.module";
import { SpinnerComponent } from "./shared/spinner.component";
import { ActiveBudgetListComponent } from "./components/active-budget-list/active-budget-list.component";
import { CreateBudgetComponent } from "./components/create-budget/create-budget.component";
import { ShipmentsComponent } from "./components/shipments/shipments.component";
import { BudgetHistoryComponent } from "./components/budget-history/budget-history.component";
import { UsersComponent } from "./components/users/users.component";
import { AdminBudgetsComponent } from "./components/admin-budgets/admin-budgets.component";
import { SettingsComponent } from "./components/settings/settings.component";
import { MyProfileComponent } from "./components/my-profile/my-profile.component";
import { LoginComponent } from "./components/login/login.component";
import { AlertService } from "./services";
import { ClientListComponent } from "./components/client-list/client-list.component";
import { ProviderListComponent } from "./components/provider-list/provider-list.component";
import { ClientLayoutComponent } from "./components/client-layout/client-layout.component";
import { ClientCreateComponent } from "./components/client-create/client-create.component";
import { ClientEditComponent } from "./components/client-edit/client-edit.component";
import {
  MatTable,
  MatTableModule,
  MatPaginatorModule
} from "@angular/material";
import { ClientsService } from "./services/clients.service";
import { AppConfig } from "./app.config";
import { WorksService } from "./services/works.service";
import { UserLayoutComponent } from './components/user-layout/user-layout.component';
import { UserEditComponent } from './components/user-edit/user-edit.component';
import { UserCreateComponent } from './components/user-create/user-create.component';

const DEFAULT_PERFECT_SCROLLBAR_CONFIG: PerfectScrollbarConfigInterface = {
  suppressScrollX: true,
  wheelSpeed: 2,
  wheelPropagation: true
};

@NgModule({
  declarations: [
    AppComponent,
    FullComponent,
    AppHeaderComponent,
    SpinnerComponent,
    AppBlankComponent,
    AppSidebarComponent,
    ActiveBudgetListComponent,
    CreateBudgetComponent,

    ShipmentsComponent,
    BudgetHistoryComponent,
    UsersComponent,
    AdminBudgetsComponent,
    SettingsComponent,
    MyProfileComponent,
    LoginComponent,
    ClientListComponent,
    ProviderListComponent,
    ClientLayoutComponent,
    ClientCreateComponent,
    ClientEditComponent,
    UserLayoutComponent,
    UserEditComponent,
    UserCreateComponent
  ],
  imports: [
    BrowserModule,
    BrowserAnimationsModule,
    DemoMaterialModule,
    MatTableModule,
    ReactiveFormsModule,
    MatPaginatorModule,
    FormsModule,
    FlexLayoutModule,
    HttpClientModule,
    PerfectScrollbarModule,
    SharedModule,
    NgMultiSelectDropDownModule.forRoot(),
    RouterModule.forRoot(AppRoutes)
  ],
  providers: [
    AlertService,
    ClientsService,
    WorksService,
    AppConfig,
    {
      provide: PERFECT_SCROLLBAR_CONFIG,
      useValue: DEFAULT_PERFECT_SCROLLBAR_CONFIG
    }
  ],
  bootstrap: [AppComponent]
})
export class AppModule {}

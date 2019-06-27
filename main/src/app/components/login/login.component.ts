import { Component, OnInit } from "@angular/core";
import {
  FormGroup,
  FormBuilder,
  Validators,
  ReactiveFormsModule
} from "@angular/forms";
import { ActivatedRoute, Router } from "@angular/router";
import { AlertService } from "../../services";

@Component({
  selector: "app-login",
  templateUrl: "./login.component.html",
  styleUrls: ["./login.component.scss"]
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  loading = false;
  returnUrl: string;
  hidePassword = true;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private fb: FormBuilder,
    private alertService: AlertService
  ) {
    this.loginForm = fb.group({
      usuario: [undefined, Validators.required],
      contrasena: [undefined, Validators.required]
    });
  }

  ngOnInit() {
    this.returnUrl =
      this.route.snapshot.queryParams["returnUrl"] != "/inicio"
        ? this.route.snapshot.queryParams["returnUrl"]
        : "/";
  }

  login() {
    if (!this.loginForm.valid) {
      this.alertService.error("Los datos no son válidos.", "OK");
      return false;
    }
    if (
      this.loginForm.value["usuario"] == "santiago@pam.com.uy" &&
      this.loginForm.value["contrasena"] == "12345678"
    ) {
      this.alertService.success("Login Tato OK");
      this.router.navigate(["/presupuestos/crear"]);
    } else if (
      this.loginForm.value["usuario"] == "pam@pam.com.uy" &&
      this.loginForm.value["contrasena"] == "12345678"
    ) {
      this.alertService.success("Login User OK");
      this.router.navigate(["/trabajos-activos"]);
    } else {
      this.alertService.error("Los datos no son válidos.", "OK");
      return false;
    }

    //this.loading = true;
    //this.router.navigate(['/admin-usuarios']);
    /*this.authenticationService.login(this.loginForm.value).subscribe(
			data => {
				let allBusinessesString = localStorage.getItem('businesses');
				let allBusinesses: Empresa[] = JSON.parse(allBusinessesString);
				this.usersService.userName = JSON.parse(localStorage.getItem('user')).nombre;
				if (this.authenticationService.can('systemAdmin')) {
					this.router.navigate(['/admin-usuarios']);
				} else if (allBusinesses.length == 1) {
					this.router.navigate(['/catalogo']);
				} else {
					this.router.navigate(['/seleccionar-empresa']);
				}
			},
			error => {
				this.alertService.error('Usuario o contraseña incorrectos', 'OK');
				this.loading = false;
			}
    );*/
  }

  goToRegister() {
    this.router.navigate(["/registro"]);
  }
  goToResetPassword() {
    this.router.navigate(["/olvide-mi-contrasena"]);
  }
}

import {Component} from '@angular/core';
import {FormGroup} from "@angular/forms";
import {UserClientService} from "../../../services/user/user-client.service";
import {UserRegister} from "../../../model/user/user-register";

@Component({
  selector: 'app-user-register',
  templateUrl: './user-register.component.html',
})
export class UserRegisterComponent {
  public model: UserRegister = {};
  public success: boolean = false;

  constructor(
    private readonly userClient: UserClientService,
  ) { }

  public onSubmit(form: FormGroup): void {
    this.userClient
      .register(form)
      .toPromise()
      .then(this.afterRegister.bind(this));
  }

  private afterRegister(): void {
    this.success = true;
  }
}

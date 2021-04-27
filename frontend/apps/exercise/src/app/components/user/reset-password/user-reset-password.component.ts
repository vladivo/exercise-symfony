import {Component} from '@angular/core';
import {UserClientService} from "../../../services/user/user-client.service";
import {UserPasswordReset} from "../../../model/user/user-password-reset";
import {FormGroup} from "@angular/forms";

@Component({
  selector: 'app-user-reset-password',
  templateUrl: './user-reset-password.component.html',
})
export class UserResetPasswordComponent {
  public model: UserPasswordReset = {};
  public success: boolean = false;

  constructor(
    private readonly userClient: UserClientService,
  ) { }

  public onSubmit(form: FormGroup): void {
    this.userClient
      .resetPassword(form)
      .toPromise()
      .then(this.onSuccess.bind(this));
  }

  private onSuccess(): void {
    this.success = true;
  }
}

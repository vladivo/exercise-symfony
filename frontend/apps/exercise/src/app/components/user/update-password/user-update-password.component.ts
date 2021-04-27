import {Component} from '@angular/core';
import {FormGroup} from "@angular/forms";
import {UserClientService} from "../../../services/user/user-client.service";
import {UserPasswordUpdate} from "../../../model/user/user-password-update";

@Component({
  selector: 'app-user-update-password',
  templateUrl: './user-update-password.component.html',
})
export class UserUpdatePasswordComponent {
  public model: UserPasswordUpdate = {};
  public success = false;

  constructor(
    private readonly userClient: UserClientService,
  ) { }

  public onSubmit(form: FormGroup): void {
    this.userClient
      .updatePassword(form)
      .toPromise()
      .then(this.onSuccess.bind(this));
  }

  private onSuccess(): void {
    this.success = true;
  }
}

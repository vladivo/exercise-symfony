import {Component} from '@angular/core';
import {FormGroup} from "@angular/forms";
import {Router} from "@angular/router";
import {UserClientService} from "../../../services/user/user-client.service";
import {UserLogin} from "../../../model/user/user-login";

@Component({
  selector: 'app-user-login',
  templateUrl: './user-login.component.html',
})
export class UserLoginComponent {
  public model: UserLogin = {};

  constructor(
    private readonly userClient: UserClientService,
    private readonly router: Router,
  ) { }

  public onSubmit(form: FormGroup): void {
    this.userClient
      .login(form)
      .toPromise()
      .then(this.redirectToProfile.bind(this));
  }

  private redirectToProfile(): void {
    this.router.navigateByUrl('/user/profile');
  }
}

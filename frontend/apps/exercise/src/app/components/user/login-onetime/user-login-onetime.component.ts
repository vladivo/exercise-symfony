import {AfterViewChecked, Component} from '@angular/core';
import {UserClientService} from "../../../services/user/user-client.service";
import {ActivatedRoute, Router} from "@angular/router";

@Component({
  selector: 'app-user-login-onetime',
  templateUrl: './user-login-onetime.component.html',
})
export class UserLoginOnetimeComponent implements AfterViewChecked {
  private submitted: boolean = false;
  public status: string = 'logging out';

  public constructor(
    private readonly userClient: UserClientService,
    private readonly activatedRoute: ActivatedRoute,
    private readonly router: Router,
  ) {}

  public ngAfterViewChecked(): void {
    if (this.submitted) {
      return;
    }

    this.submitted = true;

    const token: string = this.activatedRoute.snapshot.params['token'];

    this.userClient
      .loginOneTime(token)
      .toPromise()
      .then(this.afterLogin.bind(this));
  }

  private afterLogin(): void {
    this.router.navigateByUrl('user/password/update');
  }
}

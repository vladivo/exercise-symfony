import {Component, OnInit} from '@angular/core';
import {UserClientService} from "../../../services/user/user-client.service";
import {Router} from "@angular/router";

@Component({
  selector: 'app-user-logout',
  templateUrl: './user-logout.component.html',
})
export class UserLogoutComponent implements OnInit {
  public status: string = 'logging out';

  public constructor(
    private readonly userClient: UserClientService,
    private readonly router: Router,
  ) {}

  public ngOnInit(): void {
    this.userClient
      .logout()
      .toPromise()
      .then(this.afterLogout.bind(this))
  }

  private afterLogout(): void
  {
    this.router.navigateByUrl('/');
  }
}

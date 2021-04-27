import {Component} from '@angular/core';
import {Observable} from "rxjs";
import {UserClientService} from "../../../services/user/user-client.service";
import {UserProfile} from "../../../model/user/user-profile";

@Component({
  selector: 'app-user-profile',
  templateUrl: './user-profile.component.html',
})
export class UserProfileComponent {
  public _profile$!: Observable<UserProfile>;

  constructor(private userClient: UserClientService) { }

  public get profile$(): Observable<UserProfile> {
    if (!this._profile$) {
      this._profile$ = this.userClient.profile();
    }

    return this._profile$;
  }
}

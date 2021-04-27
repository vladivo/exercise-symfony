import {Component, OnInit} from '@angular/core';
import {UserClientService} from "../../../services/user/user-client.service";
import {UserProfile} from "../../../model/user/user-profile";

@Component({
  selector: 'app-home-page',
  templateUrl: './home-page.component.html',
})
export class HomePageComponent implements OnInit {
  public profile?: UserProfile
  public hasError: boolean = false;

  public constructor(
    private readonly userClient: UserClientService,
  ) {}

  public ngOnInit() {
    this.userClient.profile().toPromise()
      .then(this.setProfile.bind(this))
      .catch(this.setError.bind(this));
  }

  private setProfile(profile: UserProfile): void {
    this.profile = profile;
  }

  private setError(): void {
    this.hasError = true;
  }
}

import {HttpClient} from "@angular/common/http";
import {FormGroup} from "@angular/forms";
import {Observable} from "rxjs";
import {Injectable} from "@angular/core";
import {UserProfile} from "../../model/user/user-profile";

@Injectable()
export class UserClientService {
  private readonly pathRegister = '/api/user/register';
  private readonly pathLogin = '/api/user/login';
  private readonly pathLogout = '/api/user/logout';
  private readonly pathProfile = '/api/user/profile';
  private readonly pathResetPassword = '/api/user/password/reset';
  private readonly pathUpdatePassword = '/api/user/password/update';
  private readonly pathLoginOneTime = '/api/user/login/onetime';

  public constructor(private httpClient: HttpClient) {}

  public register(form: FormGroup): Observable<unknown> {
    return this.httpClient.post(this.pathRegister, form.value);
  }

  public login(form: FormGroup): Observable<unknown> {
    return this.httpClient.post(this.pathLogin, form.value);
  }

  public logout(): Observable<unknown> {
    return this.httpClient.post(this.pathLogout, undefined);
  }

  public profile(): Observable<UserProfile> {
    return this.httpClient.get<UserProfile>(this.pathProfile);
  }

  public resetPassword(form: FormGroup): Observable<unknown> {
    return this.httpClient.post(this.pathResetPassword, form.value);
  }

  public updatePassword(form: FormGroup): Observable<unknown> {
    return this.httpClient.post(this.pathUpdatePassword, form.value);
  }

  public loginOneTime(token: string): Observable<unknown>
  {
    return this.httpClient.post(`${this.pathLoginOneTime}/${token}`, undefined);
  }
}

import {Component} from '@angular/core';
import {Observable} from "rxjs";
import {AlertService} from "../../../../services/error/alert.service";
import {AppError} from "../../../../model/error/app-error";

@Component({
  selector: 'app-error',
  templateUrl: './error.component.html',
})
export class ErrorComponent {
  public constructor(
    private readonly errorHandler: AlertService,
  ) {}

  public get errors$(): Observable<AppError[]> {
    return this.errorHandler.getErrors();
  }

  public resetErrors(): void {
    this.errorHandler.resetErrors();
  }
}

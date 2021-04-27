import {HttpErrorResponse} from "@angular/common/http";
import {AppError} from "../../model/error/app-error";
import {AlertService} from "./alert.service";
import {ErrorHandler, Injectable, NgZone} from "@angular/core";

@Injectable()
export class AppErrorHandler implements ErrorHandler {

  public constructor(private readonly alertService: AlertService, private zone: NgZone) {
  }

  public handleError(error: any): void {
    this.zone.run((): void => {
      this.handle(error);
    });
  }

  private handle(error: any): void {
    if (error instanceof HttpErrorResponse) {
      return this.handleHttpError(error);
    }

    if (error.rejection && (error.rejection instanceof HttpErrorResponse)) {
      return this.handleHttpError(error.rejection);
    }

    this.handleUnknownError(error as Error);
  }

  private handleHttpError(response: HttpErrorResponse): void {
    if (response.error.errors) {
      this.alertService.setErrors(...response.error.errors as AppError[]);

      return;
    }

    if (response.error.error) {
      this.alertService.setErrors({
        status: response.status,
        title: response.error.error,
      });

      return;
    }

    this.alertService.setErrors({
      status: response.status,
      title: response.message,
    });
  }

  private handleUnknownError(error: Error): void {
    this.alertService.setErrors({
      title: error.message,
    })
  }
}

import {AppError} from "../../model/error/app-error";
import {Observable, Subject, Subscription} from "rxjs";
import {Injectable, OnDestroy} from "@angular/core";
import {Event, NavigationStart, Router} from "@angular/router";

@Injectable()
export class AlertService implements AlertService, OnDestroy {
  private errorsChange: Subject<AppError[]> = new Subject<AppError[]>();
  private routerEventSubscription: Subscription;

  public constructor(router: Router) {
    this.routerEventSubscription = router.events.subscribe(this.routerEventHandler.bind(this))
  }

  private routerEventHandler(event: Event): void {
    if (event instanceof NavigationStart) {
      this.resetErrors();
    }
  }

  public ngOnDestroy(): void {
    this.routerEventSubscription.unsubscribe();
  }

  public getErrors(): Observable<AppError[]> {
    return this.errorsChange;
  }

  public resetErrors(): void {
    this.errorsChange.next(undefined);
  }

  public setErrors(...errors: AppError[]): void {
    this.errorsChange.next([...errors])
  }
}

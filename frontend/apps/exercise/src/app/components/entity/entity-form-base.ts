import {EntityComponent} from "../../model/entity-component/entity-component";
import {Entity} from "../../model/entity/entity";
import {EntityClientService} from "../../services/entity/entity-client.service";
import {Router} from "@angular/router";
import {FormGroup} from "@angular/forms";
import {Observable} from "rxjs";
import {shareReplay} from "rxjs/operators";

export abstract class EntityFormBase implements EntityComponent {
  public entity!: Entity;
  public entityTypeName!: string;

  protected constructor(
    private readonly entityClient: EntityClientService,
    private readonly router: Router,
  ) {}

  public get title(): string {
    return this.entity.id === 0
      ? `Create new ${this.entityTypeName}`
      : `Edit ${this.entityTypeName} ${this.entity.id}`
  }

  public onSubmit(form: FormGroup): Observable<unknown> {
    return this.entity.id === 0 ? this.createEntity(form) : this.updateEntity(form)
  }

  private createEntity(form: FormGroup): Observable<unknown> {
    const result$: Observable<string> = this.entityClient
      .create(this.entity.type, form)
      .pipe(shareReplay());

    result$.toPromise().then(this.redirectCreate.bind(this));

    return result$;
  }

  private updateEntity(form: FormGroup): Observable<unknown> {
    const result$: Observable<unknown> = this.entityClient
      .update(this.entity.type, this.entity.id, form)
      .pipe(shareReplay());

    result$.toPromise().then(this.redirectUpdate.bind(this));

    return result$;
  }

  private redirectCreate(url: string): void {
    const urlObject = new URL(url);
    this.router.navigateByUrl(urlObject.pathname);
  }

  private redirectUpdate(): void {
    this.router.navigate(['/entity', this.entity.type, this.entity.id]);
  };
}

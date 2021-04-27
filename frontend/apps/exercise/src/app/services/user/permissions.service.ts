import {Injectable} from "@angular/core";
import {EntityClientService} from "../entity/entity-client.service";
import {Observable} from "rxjs";
import {Permission} from "../../model/entity/permission";
import {EntityType} from "../../model/entity-component/entity-type";

@Injectable()
export class PermissionsService {
  private permissions$?: Observable<Permission[]>;

  public constructor(
    private readonly entityClient: EntityClientService,
  ) {}

  public refresh(): void {
    this.permissions$ = this.entityClient.find(EntityType.permission) as Observable<Permission[]>;
  }

  public getPermissions(): Observable<Permission[]> {
    if (!this.permissions$) {
      this.refresh();
    }

    return this.permissions$!;
  }
}

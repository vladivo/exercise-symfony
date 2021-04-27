import {Injectable} from "@angular/core";
import {EntityClientService} from "../entity/entity-client.service";
import {Observable} from "rxjs";
import {EntityType} from "../../model/entity-component/entity-type";
import {Role} from "../../model/entity/role";

@Injectable()
export class RolesService {
  private roles$?: Observable<Role[]>;

  public constructor(
    private readonly entityClient: EntityClientService,
  ) {}

  public refresh(): void {
    this.roles$ = this.entityClient.find(EntityType.role) as Observable<Role[]>;
  }

  public getRoles(): Observable<Role[]> {
    if (!this.roles$) {
      this.refresh();
    }

    return this.roles$!;
  }
}

import {Component} from '@angular/core';
import {Role} from "../../../../model/entity/role";
import {EntityFormBase} from "../../entity-form-base";
import {EntityClientService} from "../../../../services/entity/entity-client.service";
import {Router} from "@angular/router";
import {PermissionsService} from "../../../../services/user/permissions.service";
import {Observable} from "rxjs";
import {Permission} from "../../../../model/entity/permission";

@Component({
  selector: 'app-role-form',
  templateUrl: './role-form.component.html',
})
export class RoleFormComponent extends EntityFormBase {
  public entity!: Role;
  public entityTypeName = 'role';

  public constructor(
    entityClient: EntityClientService,
    router: Router,
    private readonly permissionsService: PermissionsService,
  ) {
    super(entityClient, router);
  }

  public get permissionsList$(): Observable<Permission[]> {
    return this.permissionsService.getPermissions();
  }
}

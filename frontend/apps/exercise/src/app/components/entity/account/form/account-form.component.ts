import {Component} from '@angular/core';
import {Account} from "../../../../model/entity/account";
import {EntityFormBase} from "../../entity-form-base";
import {EntityClientService} from "../../../../services/entity/entity-client.service";
import {Router} from "@angular/router";
import {RolesService} from "../../../../services/user/roles.service";
import {Observable} from "rxjs";
import {Role} from "../../../../model/entity/role";

@Component({
  selector: 'app-account-form',
  templateUrl: './account-form.component.html',
})
export class AccountFormComponent extends EntityFormBase{
  public entity!: Account;
  public entityTypeName = 'account';

  public constructor(
    entityClient: EntityClientService,
    router: Router,
    private readonly rolesService: RolesService,
  ) {
    super(entityClient, router);
  }

  public get rolesList$(): Observable<Role[]> {
    return this.rolesService.getRoles();
  }
}

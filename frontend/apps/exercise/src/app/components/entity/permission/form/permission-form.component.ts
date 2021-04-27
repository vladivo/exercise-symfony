import {Component} from '@angular/core';
import {Permission} from "../../../../model/entity/permission";
import {EntityClientService} from "../../../../services/entity/entity-client.service";
import {Router} from "@angular/router";
import {EntityFormBase} from "../../entity-form-base";

@Component({
  selector: 'app-permission-form',
  templateUrl: './permission-form.component.html',
})
export class PermissionFormComponent extends EntityFormBase{
  public entity!: Permission;
  public entityTypeName = 'permission';

  public constructor(entityClient: EntityClientService, router: Router) {
    super(entityClient, router);
  }
}

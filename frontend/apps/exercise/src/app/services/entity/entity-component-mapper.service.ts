import {PermissionPreviewComponent} from "../../components/entity/permission/preview/permission-preview.component";
import {PermissionFullComponent} from "../../components/entity/permission/full/permission-full.component";
import {Injectable, Type} from "@angular/core";
import {PermissionFormComponent} from "../../components/entity/permission/form/permission-form.component";
import {EntityComponentMap} from "../../model/entity-component/entity-component-map";
import {EntityType} from "../../model/entity-component/entity-type";
import {EntityViewMode} from "../../model/entity-component/entity-view-mode";
import {RolePreviewComponent} from "../../components/entity/role/preview/role-preview.component";
import {RoleFullComponent} from "../../components/entity/role/full/role-full.component";
import {RoleFormComponent} from "../../components/entity/role/form/role-form.component";
import {AccountPreviewComponent} from "../../components/entity/account/preview/account-preview.component";
import {AccountFullComponent} from "../../components/entity/account/full/account-full.component";
import {AccountFormComponent} from "../../components/entity/account/form/account-form.component";

@Injectable()
export class EntityComponentMapperService {
  private readonly componentMap: EntityComponentMap = {
    [EntityType.permission]: {
      [EntityViewMode.list]: PermissionPreviewComponent,
      [EntityViewMode.full]: PermissionFullComponent,
      [EntityViewMode.form]: PermissionFormComponent,
    },
    [EntityType.role]: {
      [EntityViewMode.list]: RolePreviewComponent,
      [EntityViewMode.full]: RoleFullComponent,
      [EntityViewMode.form]: RoleFormComponent,
    },
    [EntityType.account]: {
      [EntityViewMode.list]: AccountPreviewComponent,
      [EntityViewMode.full]: AccountFullComponent,
      [EntityViewMode.form]: AccountFormComponent,
    },
  }

  public getComponentType(type: EntityType, mode: EntityViewMode): Type<unknown> {
    return this.componentMap[type]![mode];
  }
}

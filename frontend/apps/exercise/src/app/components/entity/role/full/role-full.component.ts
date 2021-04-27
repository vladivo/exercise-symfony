import {Component, OnInit} from '@angular/core';
import {EntityComponent} from "../../../../model/entity-component/entity-component";
import {Role} from "../../../../model/entity/role";
import {PermissionsService} from "../../../../services/user/permissions.service";
import {Permission} from "../../../../model/entity/permission";
import {Observable} from "rxjs";
import {map} from "rxjs/operators";

@Component({
  selector: 'app-role-full',
  templateUrl: './role-full.component.html',
})
export class RoleFullComponent implements EntityComponent, OnInit {
  public entity!: Role;
  public permissionNames$?: Observable<string[]>;

  public constructor(
    private readonly permissionsService: PermissionsService,
  ) {}

  public ngOnInit(): void {
    this.permissionNames$ = this.permissionsService.getPermissions().pipe(
      map(this.initPermissionNames.bind(this)),
    );
  }

  private initPermissionNames(permissions: Permission[]): string[] {
    return permissions
      .filter((permission: Permission): boolean => this.entity.permissions.includes(permission.id))
      .map((permission: Permission): string => permission.name);
  }
}

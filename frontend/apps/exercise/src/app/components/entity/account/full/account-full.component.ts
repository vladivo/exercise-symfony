import {Component, OnInit} from '@angular/core';
import {EntityComponent} from "../../../../model/entity-component/entity-component";
import {Account} from "../../../../model/entity/account";
import {Observable} from "rxjs";
import {map} from "rxjs/operators";
import {RolesService} from "../../../../services/user/roles.service";
import {Role} from "../../../../model/entity/role";

@Component({
  selector: 'app-account-full',
  templateUrl: './account-full.component.html',
})
export class AccountFullComponent implements EntityComponent, OnInit {
  public entity!: Account;
  public roleNames$?: Observable<string[]>;

  public constructor(
    private readonly rolesService: RolesService,
  ) {}

  public ngOnInit(): void {
    this.roleNames$ = this.rolesService.getRoles().pipe(
      map(this.initRoleNames.bind(this)),
    );
  }

  private initRoleNames(roles: Role[]): string[] {
    return roles
      .filter((role: Role): boolean => this.entity.roles.includes(role.id))
      .map((role: Role): string => role.name);
  }
}

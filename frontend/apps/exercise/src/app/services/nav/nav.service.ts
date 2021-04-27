import {NavItem} from "../../model/nav/nav-item";
import {NavType} from "../../model/nav/nav-type";
import {Injectable} from "@angular/core";
import {EntityType} from "../../model/entity-component/entity-type";

@Injectable()
export class NavService {
  private readonly navs: Record<NavType, NavItem[]> = {
    [NavType.admin]: [
      { title: 'Permissions', path: `entity/${EntityType.permission}` },
      { title: 'Roles', path: `entity/${EntityType.role}` },
      { title: 'Accounts', path: `entity/${EntityType.account}` },
    ],
    [NavType.user]: [
      { title: 'Register', path: '/user/register' },
      { title: 'Login', path: '/user/login' },
      { title: 'Logout', path: '/user/logout' },
      { title: 'Profile', path: '/user/profile' },
      { title: 'Reset password', path: '/user/password/reset' },
      { title: 'Update password', path: '/user/password/update' },
    ]
  };

  public getNav(type: NavType): NavItem[]
  {
    return this.navs[type];
  }
}

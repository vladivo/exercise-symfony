import {Component, Input} from '@angular/core';
import {NavType} from "../../../../model/nav/nav-type";
import {NavService} from "../../../../services/nav/nav.service";
import {NavItem} from "../../../../model/nav/nav-item";

@Component({
  selector: 'app-nav',
  templateUrl: './nav.component.html',
})
export class NavComponent {
  @Input() private type!: NavType;
  @Input() public title!: string;

  public constructor(private readonly navService: NavService) { }

  public get nav(): NavItem[] {
    return this.navService.getNav(this.type);
  }
}

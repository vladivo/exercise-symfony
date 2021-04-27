import {Component} from '@angular/core';
import {NavType} from "../../../model/nav/nav-type";

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
})
export class HeaderComponent {
  public navTypes: typeof NavType = NavType;
}

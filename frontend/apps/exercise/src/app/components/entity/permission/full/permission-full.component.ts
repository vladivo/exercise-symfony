import {Component} from '@angular/core';
import {Permission} from "../../../../model/entity/permission";
import {EntityComponent} from "../../../../model/entity-component/entity-component";

@Component({
  selector: 'app-permission-full',
  templateUrl: './permission-full.component.html',
})
export class PermissionFullComponent implements EntityComponent {
  public entity!: Permission;
}

import {Component} from '@angular/core';
import {EntityComponent} from "../../../../model/entity-component/entity-component";
import {Role} from "../../../../model/entity/role";

@Component({
  selector: 'app-role-preview',
  templateUrl: './role-preview.component.html',
})
export class RolePreviewComponent implements EntityComponent {
  public entity!: Role;
}

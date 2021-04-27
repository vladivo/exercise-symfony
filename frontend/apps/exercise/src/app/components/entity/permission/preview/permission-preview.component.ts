import {Component} from '@angular/core';
import {Permission} from "../../../../model/entity/permission";
import {EntityComponent} from "../../../../model/entity-component/entity-component";

@Component({
  selector: 'app-permission-preview',
  templateUrl: './permission-preview.component.html',
})
export class PermissionPreviewComponent implements EntityComponent {
  public entity!: Permission;
}

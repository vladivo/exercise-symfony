import {Component, Input} from '@angular/core';
import {Entity} from "../../../../model/entity/entity";

@Component({
  selector: 'app-entity-actions',
  templateUrl: './entity-actions.component.html',
})
export class EntityActionsComponent {
  @Input() public entity!: Entity;
  @Input() public view: boolean = true;
  @Input() public edit: boolean = true;
  @Input() public delete: boolean = true;
}
